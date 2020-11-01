@extends('welcome')
@section('content')
<section id="content">
  <div class="container_12">
    <div class="grid_12">
      <div class="wrap pad-3">
        <div class="block-5">
          <h3 class="p5">help desk :</h3>
          <a href="#" class="link">contact@marocnst.ma</a>
          <p>
            <!--a href="#" class="link">--></a>
            <a href="#" class="link">marocnst@gmail.com</a>
            <p>.................................................................... </p>
            <div class="map img-border">
              <img src="https://www.marocnst.ma/public/old_nst/images/gl-internet3.jpg" alt="" class="img-border">
            </div>
            <br>
            <dl>
              <dd>
              <dt>
              <dd><span>Adresse:</span> N° 97 Rue Araar,<br>Etage 3, Mers Sultan.<br> Casablanca - Maroc</dd>
              </dt>
              <dd><span>Mobile: </span>(+212) 661 98 40 88</dd>
              <dd>............. (+212) 661 92 20 03</dd>
              <dd>............. (+212) 661 92 30 70</dd>
              <dd><span>Téléphone: </span>(+212) 522 89 56 47</dd>
              <dd><span>E-mail: </span><a href="#" class="link">contact@marocnst.ma</a></dd>
            </dl>
        </div>
        <div class="block-6">
          <h3>Entrer en contact</h3>
          <form id="form" method="post">

            <form>
              <fieldset>
                <small id="err-nom" style="color: red"> </small>
                <label> <input type="text" name="nom" placeholder="nom"></label>
                <small id="err-email" style="color: red"> </small>
                <label><input type="text" name="email" placeholder="email"></label>
                <small id="err-gsm" style="color: red"> </small>
                <label><input type="text" name="gsm" placeholder="gsm"></label>
                <small id="err-message" style="color: red"> </small>
                <label><textarea name="message" placeholder="message"></textarea></label>
                <div class="btns">

                  <a class="button" onClick="document.getElementById('form').reset()">Effacer</a>
                  <a class="button" onClick="save()">Envoyer</a></div>
              </fieldset>
            </form>

          </form>
          <br><br>
          <span id="res_msg"></span>
          
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</section>

@endsection
@section('script')
<script>
  $(document).ready(function() {
    document.getElementById('form').reset()
  });


  function save() {

    var inputs = {
      "nom": document.getElementsByName('nom')[0].value,
      "email": document.getElementsByName('email')[0].value,
      "gsm": document.getElementsByName('gsm')[0].value,
      "message": document.getElementsByName('message')[0].value,
    };

    var StringData = $.ajax({
      url: "http://127.0.0.1:8000/system/request/store",
      type: "POST",
      async: false,
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: inputs
    }).responseText;
    jsonData = JSON.parse(StringData);
    console.log(jsonData)
    if ($.isEmptyObject(jsonData.error)) {

      clearInputs(jsonData.inputs);

      if(jsonData.check == "done"){
        document.getElementById('res_msg').innerHTML = '<h3 style="color : #44a7bb; text-align:center; " >votre demande est envoyée avec succès</h3>';
      }else{
        document.getElementById('res_msg').innerHTML = '<h3 style="color : #fb052c; text-align:center; " >votre demande n\'est pas bien envoyée </h3>'
      }

    } else {
      clearInputs(jsonData.inputs);
      printErrorMsg(jsonData.error);
      
    }
  }

  function printErrorMsg(msg) {
    $.each(msg, function(key, value) {



      document.getElementById("err-" + key).innerHTML = value;

    });

  }

  function clearInputs(msg) {


    $.each(msg, function(key, value) {

      document.getElementById("err-" + key).innerHTML = "";

    });

  }
</script>
@endsection