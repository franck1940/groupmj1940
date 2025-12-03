
$(document).ready(function () {
    const camerFeed = document.getElementById("cameraFeed");
    if (camerFeed) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                camerFeed.srcObject = stream;
            }).catch(error => {
                console.error("Error accessing camera", error);
            })
    }
})