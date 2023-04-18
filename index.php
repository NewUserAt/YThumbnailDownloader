<?php
  if(isset($_POST['button'])){
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $downloadImg = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment;filename="thumbnail.jpg"');
    echo $downloadImg;
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Thumbnail Downloader</title>
  <style> 
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body{
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: pink;
}
::selection{
  color: #fff;
  background: #7D2AE8;
}
form{
  width: 450px;
  background: #fff;
  padding: 30px ;
  border-radius: 5px;
  box-shadow: 10px 10px 13px rgba(0,0,0,0.1);
}
form header{
  text-align: center;
  font-size: 28px;
  font-weight: 500;
  margin-top: 10px;
  color: #7D2AE8;
}
form .url-input{
  margin: 30px 0;
}
.url-input .title{
  font-size: 18px;
  color: #373737;
}
.url-input .field{
  margin-top: 5px;
  height: 50px;
  width: 100%;
  position: relative;
}
.url-input .field input{
  height: 100%;
  width: 100%;
  border: none;
  outline: none;
  padding: 0 15px;
  font-size: 15px;
  background: #F1F1F7;
  border-bottom: 2px solid #ccc;
  font-family: 'Noto Sans', sans-serif;
}
.url-input .field input::placeholder{
  color: #b3b3b3;
}
.url-input .field .bottom-line{
  position: absolute;
  left: 0;
  bottom: 0;
  height: 2px;
  width: 100%;
  background: #7D2AE8;
  transform: scale(0);
  transition: transform 0.3s ease;
}
.url-input .field input:focus ~ .bottom-line,
.url-input .field input:valid ~ .bottom-line{
  transform: scale(1);
}
form .preview-area{
  border-radius: 5px;
  height: 220px;
  display: flex;
  overflow: hidden;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border: 2px dashed #8e46ec;
}
.preview-area.active{
  border: none;
}
.preview-area .thumbnail{
  width: 100%;
  display: none;
  border-radius: 5px;
}
.preview-area.active .thumbnail{
  display: block;
}
.preview-area.active .icon,
.preview-area.active p{
  display: none;
}
.preview-area .icon{
  color: #8e46ec;
  font-size: 80px;
}
.preview-area p{
  color: #8e46ec;
  margin-top: 25px;
}
form .download-btn{
  color: #fff;
  height: 53px;
  width: 100%;
  outline: none;
  border: none;
  font-size: 17px;
  font-weight: 500;
  cursor: pointer;
  margin: 30px 0 20px 0;
  border-radius: 5px;
  background: #7D2AE8;
  pointer-events: none;
  transition: background 0.3s ease;
}
.download-btn:hover{
  background: #6616d0;
}
@media screen and (max-width: 460px){
  body{
    padding: 0 20px;
  }
  form header{
    font-size: 24px;
  }
  .url-input .field,
  form .download-btn{
    height: 45px;
  }
  form .download-btn{
    font-size: 15px;
  }
  form .preview-area{
    height: 130px;
  }
  .preview-area .icon{
    font-size: 50px;
  }
  .preview-area p{
    margin-top: 10px;
    font-size: 12px;
  }
}

  </style>
</head>
<body>
  <form action="index.php" method="POST">
    <header>Thumbnail Downloader</header>
    <div class="url-input">
      <p class="title">Paste video url:</p>
      <div class="field">
        <input type="text"placeholder="Paste Your URL Here" required>
        <input class="hidden-input" type="hidden" name="imgurl">
        <p class="bottom-line"></p>
      </div>
    </div>
    <div class="preview-area">
      <img class="thumbnail" src="" alt="">
      <i class="icon fas fa-cloud-download-alt"></i>
      <p>See preview Of Thumbnail</p>
    </div>
    <button class="download-btn" type="submit" name="button">Download Thumbnail</button>
  </form>

  <script>
    const urlField = document.querySelector(".field input"),
    previewArea = document.querySelector(".preview-area"),
    imgTag = previewArea.querySelector(".thumbnail"),
    hiddenInput = document.querySelector(".hidden-input"),
    button = document.querySelector(".download-btn");

    urlField.onkeyup = ()=>{
      let imgUrl = urlField.value;
      previewArea.classList.add("active");
      button.style.pointerEvents = "auto";
      if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){
        let vidId = imgUrl.split('v=')[1].substring(0, 11);
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
        imgTag.src = ytImgUrl;
      }else if(imgUrl.indexOf("https://youtu.be/") != -1){
        let vidId = imgUrl.split('be/')[1].substring(0, 11);
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
        imgTag.src = ytImgUrl;
      }else if(imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)){
        imgTag.src = imgUrl;
      }else{
        imgTag.src = "";
        button.style.pointerEvents = "none";
        previewArea.classList.remove("active");
      }
      hiddenInput.value = imgTag.src;
    }
  </script>
</body>
</html>
