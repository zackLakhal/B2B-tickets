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
              <img src="{{ asset('old_nst/images/gl-internet3.jpg') }}" alt="" class="img-border">
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

            <form name="contacts" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
              <fieldset>
                <label><input type="text" value="Nom" onBlur="if(this.value=='') this.value='Nom'" onFocus="if(this.value =='Nom' ) this.value=''"></label>
                <label><input type="text" value="Email" onBlur="if(this.value=='') this.value='Email'" onFocus="if(this.value =='Email' ) this.value=''"></label>
                <label><input type="text" value="Gsm" onBlur="if(this.value=='') this.value='Gsm'" onFocus="if(this.value =='Gsm' ) this.value=''"></label>
                <label><textarea onBlur="if(this.value==''){this.value='Message'}" onFocus="if(this.value=='Message'){this.value=''}">Message</textarea></label>
                <div class="btns">

                  <a href="#" class="button" onClick="document.getElementById('form').reset()">Effacer</a><a href="khalidzouine@gmail.com" class="button" onClick="document.getElementById('form').submit()">
                    <!--"document.getElementById('form').submit()"-->Envoyer</a></div>
              </fieldset>
            </form>

          </form>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</section>

@endsection