function generateQR(container, text, type){
  $(container).html('');
  $(container).qrcode({
    // render method: 'canvas', 'image' or 'div'
    render: type,

    // version range somewhere in 1 .. 40
    minVersion: 1,
    maxVersion: 40,

    // error correction level: 'L', 'M', 'Q' or 'H'
    ecLevel: 'L',

    // offset in pixel if drawn onto existing canvas
    left: 0,
    top: 0,

    // size in pixel
    size: 500,

    // code color or image element
    fill: '#000',

    // background color or image element, null for transparent background
    background: null,

    // content
    text: text,

    // corner radius relative to module width: 0.0 .. 0.5
    radius: 0,

    // quiet zone in modules
    quiet: 0,

    // modes
    // 0: normal
    // 1: label strip
    // 2: label box
    // 3: image strip
    // 4: image box
    mode: 0,

    mSize: 0.1,
    mPosX: 0.5,
    mPosY: 0.5,

    label: 'no label',
    fontname: 'sans',
    fontcolor: '#000',

    image: null
  });
}

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


