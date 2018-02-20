<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}} | Log in</title>
  <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="url" content="{{URL('')}}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL('public/template')}}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL('public/template')}}/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{URL('public/template')}}/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Custom Style -->
  <link rel="stylesheet" href="{{URL('public')}}/css/style.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="{{URL('public')}}/css/fonts.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>PRO DENPASAR</br>Analisis Sentimen Komentar</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="position: relative;">
    <p class="login-box-msg">Log In</p>

    <form action="{{URL('auth')}}" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nama" name="username" required="true">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" required="true">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember"> Ingat Saya
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
      {{ csrf_field() }}
    </form>
    <!-- loading overlay -->
    <div class="overlay" style="display: none;">
      <i class="fa fa-spinner fa-spin"></i>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{URL('public/template')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL('public/template')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{URL('public/template')}}/plugins/iCheck/icheck.min.js"></script>
<!-- jQuery Validation -->
<script src="{{URL('public/template')}}/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{URL('public/template')}}/plugins/jquery-validation/dist/localization/messages_id.js"></script>
<script>
  $(function () {
    $('input[type=checkbox]').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });

  // Form validation bahasa indonesia
  $('.login-box form').validate({
    lang: 'id',
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    },
    highlight: function(element) {
      $(element).closest('div').addClass('has-error');
    },
    unhighlight: function(element) {
      $(element).closest('div').removeClass('has-error');
    },
    submitHandler: function(form) {
      $('.login-box-body .overlay').show();
      $.ajax({
        url: form.action,
        type: 'POST',
        data: $(form).serializeArray()
      })
      .done(function(data) { console.log(data);
        if(data.status==='OK'){
          let url = $('meta[name=url]').prop('content');
          window.location.replace(url+'/dashboard');
        }
        else{
          $('.login-box-msg').addClass('has-error');
          $('.login-box-msg').text(data.message);
          $('.login-box-body .overlay').hide();
        }
      })
      .fail(function() {
        $('.login-box-msg').addClass('has-error');
        $('.login-box-msg').text('Terjadi error dalam pengiriman data');
        $('.login-box-body .overlay').hide();
      })
    }
  });
</script>
</body>
</html>
