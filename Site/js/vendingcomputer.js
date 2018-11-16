$( document ).ready(function() {

  scanner(false);

});

function scanner(active)
{
    //makes a new QR code reader
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    //searchers the camera input for a QR code
    scanner.addListener('scan', function (content) 
    {
      console.log("QR code found, content: ")
      console.log(content);

      //checks if the content contains a website
      if(content.indexOf("https") != -1 || content.indexOf("http") != -1)
      {
        window.open(content,'_blank')
      }
    });

    if(active == false)
    {
      active = true;

      //turns the webcam on
      Instascan.Camera.getCameras().then(function (cameras) {
        //checks if the computer has any cameras
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    }
    else
    {
      active = false;

      //turns the webcam off
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.stop(cameras[0]);
        }
      }).catch(function (e) {
        console.error(e);
      });
    }
}


