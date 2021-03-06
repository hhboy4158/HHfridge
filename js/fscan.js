/*
Copyright 2017 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
'use strict';

// This code is adapted from
// https://cdn.rawgit.com/Miguelao/demos/master/imagecapture.html

// window.isSecureContext could be used for Chrome
var isSecureOrigin = location.protocol === 'https:' ||
  location.host === 'localhost';
if (!isSecureOrigin) {
  alert('getUserMedia() must be run from a secure origin: HTTPS or localhost.' +
    '\n\nChanging protocol to HTTPS');
  location.protocol = 'HTTPS';
}

var constraints;
var imageCapture;
var mediaStream;

var grabFrameButton = document.querySelector('button#grabFrame');
var takePhotoButton = document.querySelector('button#takePhoto');

var canvas = document.querySelector('canvas');
var img = document.querySelector('img');
var video = document.querySelector('video');
var videoSelect = document.querySelector('select#videoSource');
var zoomInput = document.querySelector('input#zoom');

grabFrameButton.onclick = grabFrame;
takePhotoButton.onclick = takePhoto;
videoSelect.onchange = getStream;
zoomInput.oninput = setZoom;

// Get a list of available media input (and output) devices
// then get a MediaStream for the currently selected input device
navigator.mediaDevices.enumerateDevices()
  .then(gotDevices)
  .catch(error => {
    console.log('enumerateDevices() error: ', error);
  })
  .then(getStream);

// From the list of media devices available, set up the camera source <select>,
// then get a video stream from the default camera source.
function gotDevices(deviceInfos) {
  for (var i = 0; i !== deviceInfos.length; ++i) {
    var deviceInfo = deviceInfos[i];
    // console.log('Found media input or output device: ', deviceInfo);
    var option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || 'Camera ' + (videoSelect.length + 1);
      videoSelect.appendChild(option);
    }
  }
}

// Get a video stream from the currently selected camera source.
function getStream() {
  if (mediaStream) {
    mediaStream.getTracks().forEach(track => {
      track.stop();
    });
  }
  var videoSource = videoSelect.value;
  constraints = {
    video: { deviceId: videoSource ? { exact: videoSource } : undefined }
  };
  navigator.mediaDevices.getUserMedia(constraints)
    .then(gotStream)
    .catch(error => {
      console.log('getUserMedia error: ', error);
    });
}

// Display the stream from the currently selected camera source, and then
// create an ImageCapture object, using the video from the stream.
function gotStream(stream) {
  // console.log('getUserMedia() got stream: ', stream);
  mediaStream = stream;
  video.srcObject = stream;
  video.classList.remove('hidden');
  imageCapture = new ImageCapture(stream.getVideoTracks()[0]);
  getCapabilities();
}

// Get the PhotoCapabilities for the currently selected camera source.
function getCapabilities() {
  imageCapture.getPhotoCapabilities().then(function (capabilities) {
    // console.log('Camera capabilities:', capabilities);
    if (capabilities.zoom.max > 0) {
      zoomInput.min = capabilities.zoom.min;
      zoomInput.max = capabilities.zoom.max;
      zoomInput.value = capabilities.zoom.current;
      zoomInput.classList.remove('hidden');
    }
  }).catch(function (error) {
    // console.log('getCapabilities() error: ', error);
  });
}

// Get an ImageBitmap from the currently selected camera source and
// display this with a canvas element.
function grabFrame() {
  imageCapture.grabFrame().then(function (imageBitmap) {

    // console.log('Grabbed frame:', imageBitmap);
    // canvas.width = imageBitmap.width;
    canvas.width = 1108;
    // canvas.height = imageBitmap.height;
    canvas.height = 1478;
    canvas.getContext('2d').drawImage(imageBitmap, 0, 0, canvas.width, canvas.height);

    // ???????????? JPG??????
    var dataURL = canvas.toDataURL('image/jpeg', 1.0).replace("image/jpeg", "image/octet-stream");
    console.log(dataURL);
    canvas.classList.remove('hidden');

    // ?????????????????????????????????????????? XML ?????? ??????????????? convertit.php
    // ?????? ??????????????? jpg ??????
    var onmg = encodeURIComponent(dataURL);
    var xhr = new XMLHttpRequest();
    var body = "img=" + onmg;
    xhr.open('POST', "pages/fscan/convertit.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(body);
    xhr.onreadystatechange = function () {
      if (xhr.status == 200 && xhr.readyState == 4) {
        // document.getElementById("div").innerHTML = xhr.responseText;
        console.log(xhr.responseText);
      } else {
        // document.getElementById("div").innerHTML = 'loading';
        console.log("loading");
      }
    }

    // ----------------------------------------------

  }).catch(function (error) {
    console.log('grabFrame() error: ', error);
  });
  $.ajax({
            type: "POST",
            url: "pages/fscan/cmd.php",
            //data: { recipe: a},
        }).done(function(res) {
            
              switch(res){
                  case "apple" :
                  res = "??????";
                  break;
                  case "cabbage" :
                  res = "?????????";
                  break;
                  case "cauliflower" :
                  res = "?????????";
                  break;
                  case "egg" :
                  res = "???";
                  break;
                  case "eggplant" :
                  res = "??????";
                  break;
                  case "garlicSprouts" :
                  res = "??????";
                  break;
                  case "grape" :
                  res = "??????";
                  break;
                  case "greenPepper" :
                  res = "??????";
                  break;
                  case "lemon" :
                  res = "??????";
                  break;
                  case "lettuce" :
                  res = "??????";
                  break;
                  case "onion" :
                  res = "??????";
                  break;
                  case "orange" :
                  res = "??????";
                  break;
                  case "pear" :
                  res = "??????";
                  break;
                  case "pineapple" :
                  res = "??????";
                  break;
                  case "pitaya" :
                  res = "?????????";
                  break;
                  case "purpleCabbage" :
                  res = "?????????";
                  break;
                  case "qingjiangCuisine" :
                  res = "?????????";
                  break;
                  case "shallot" :
                  res = "???";
                  break;
                  case "Strawberry" :
                  res = "??????";
                  break;
                  case "sweetpepper" :
                  res = "??????";
                  break;
                  case "tomato" :
                  res = "??????";
                  break;
                  default:
                  res = "????????????";
                }
                
                $('#InsertIng').modal('show');
                document.getElementsByName("adding")[0].value = res;

        });
}


function setZoom() {
  imageCapture.setOptions({
    zoom: zoomInput.value
  });
}
















// Get a Blob from the currently selected camera source and
// display this with an img element.
// function takePhoto() {
//   var reader = new FileReader();
//   imageCapture.takePhoto().then(function (blob) {

//     console.log('Took photo:', blob);
//     // blob = new Blob(blob, {type: 'image/jpeg'});  
//     img.classList.remove('hidden');
//     img.src = URL.createObjectURL(blob);
//     reader.readAsArrayBuffer(blob);
//     // var dataUrl = img.src;
//     // var filename = "img";
//     // var blob = dataURLtoBlob(dataurl);
//     // alert(dataurl);
//     //??????ajax??????
//     // var fd = new FormData();
//     // fd.append("image", blob, "image.png");
//     // var xhr = new XMLHttpRequest();
//     // xhr.open('POST', '/server', true);
//     // xhr.send(fd);
//     // alert(fd);



//     // var fd = new FormData();
//     // fd.append('fname', 'test.img');
//     // fd.append('data', soundBlob);
//     // $.ajax({
//     //   type: 'POST',
//     //   url: '..//upload.php',
//     //   data: fd,
//     //   processData: false,
//     //   contentType: false
//     // }).done(function (data) {
//     //   console.log(data);
//     // });

//   }).catch(function (error) {
//     console.log('takePhoto() error: ', error);
//   });
// }
