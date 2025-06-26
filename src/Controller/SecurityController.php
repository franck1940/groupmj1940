<?php

namespace App\Controller;

use App\Entity\User;
use App\services\userloginservice\UserLoginServices;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Totp\TotpAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
      
         if ($this->getUser()) {
            
             return $this->redirectToRoute('app_backendmanagement');
         }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@backend/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, "value" => ""]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * @Route("/authentication/2fa/enable", name="app_2fa_enable")

     */
    #[Route(path:"/authentication/2fa/enable", name:"app_2fa_enable")]
    #[IsGranted("ROLE_USER")]
    public function enable2fa(TotpAuthenticatorInterface $totpAuthenticator, EntityManagerInterface $entityManager)
    {
        
        $user = (object) $this->getUser();
        if (!$user->isTotpAuthenticationEnabled()) {
            $user->setTotpSecret($totpAuthenticator->generateSecret());
            $entityManager->flush();
        }
          dd($totpAuthenticator->getQRContent($user));
    }

    #[Route(path:"/authentication/2fa/qr-code", name:"app_qr_code")]
    #[IsGranted("ROLE_USER")]
   public function displayGoogleAuthenticatorQrCode(TotpAuthenticatorInterface $totpAuthenticator,EntityManagerInterface $entityManager)
    {
        $writer = new PngWriter();
        $userServices= new UserLoginServices($entityManager);
        $user =(object) $this->getUser();
        $x = $userServices->findUserById($user->getId());
        $qrCodeContent = $totpAuthenticator->getQRContent($x);
        $qrCode = new QrCode($qrCodeContent,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
     );
          // dd( $qrCode);    
        $logo = new Logo(
                path:'../public/images/tlogo.jpg',
                resizeToWidth: 50,
                punchoutBackground: true
            );
            // Create generic label
            $label = new Label(
                text: '',
                textColor: new Color(255, 0, 0)
            );

            $result = $writer->write($qrCode, $logo, $label);
            // Validate the result
            $writer->validateResult($result,$qrCodeContent);
        

            header('Content-Type: '.$result->getMimeType());
            echo $result->getString();
            
            $response = new Response(  $result->getString(), 200, ['Content-Type' => 'image/png']);
            
        return $response;
    }

}
