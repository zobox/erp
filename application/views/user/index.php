<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<style>
      .left-section {
        background-color: #fff;
      }
      .right-section {
        background-color: #4A56C0;
      }
      .right-section input::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      .right-section input:-ms-input-placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      .right-section input::-ms-input-placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
      .right-section input {
        width: 100%;
        background: #3E44A8;
        border: none;
        font-size: 12px;
        height: 32px;
        padding: 0 10px;
        color: rgba(255, 255, 255, 0.7);
      }
      .right-section input:hover,
      .right-section input:focus {
        outline: none;
        box-shadow: none;
      }
      .login-button {
        border-radius: 20px;
        background-color: #E75C7D;
        color: #fff;
        font-size: 12px;
      }
      .medium-font {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
      }
      .small-font {
        font-size: 12px;
      }
      .main-div {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100% 100%;
        background-image: url('<?php echo base_url();?>app-assets/images/backgrounds/bg-2.jpg');
        width: 100%;
        min-height: 100vh;
      }
      .remember-input {
        width: auto;
      }
      .left-section .content {
        max-height: 400px;
      }
      @media only screen and (min-width: 767px) {
        .outer-content {
          min-width: 800px;
        }
        .left-section img {
          max-height: 100%;
        }
        .left-section .content {
          padding: 55px 40px;
        }
      }
      @media only screen and (max-width: 767px) and (min-width: 400px) {
        .outer-content {
          width: 60%;
        }
        .right-section .content {
          margin: 0 auto;
        }
      }
    </style>
	<body class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
      data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div
      class="d-flex main-div align-items-center justify-content-center w-100 h-100"
    >
  <div class="row outer-content">
    <div class="col-md-6 d-md-block d-none left-section">
      <div
            class="content h-100 d-flex justify-content-center align-items-center"
          > <img class="store-image img-fluid"
                        src="<?php echo base_url('userfiles/company/') . $this->config->item('logo'); ?>" alt="logo"> </div>
    </div>
    <div class="col-md-6 right-section text-white">
      <div
            class="content py-5 d-flex justify-content-between flex-column h-100"
          >
        <h5 class="card-title text-center mb-4 mb-lg-0">Welcome !</h5>
        <p class="text-center medium-font mb-4 mb-lg-0"> Sign in to your Account </p>
         <?php
                                    $attributes = array('class' => 'form-horizontal form-simple', 'id' => 'login_form', 'action' => base_url().'user/checklogin', 'method' => 'post', 'accept-charset' => 'utf-8', 'autocomplete' => 'off');
									
									//print_r($attributes);
                                    //echo form_open('user/checklogin', $attributes);
                                    ?>
						<form action="<?php echo $attributes['action'];?>" class="<?php echo $attributes['class'];?>" id="<?php echo $attributes['id'];?>" method="<?php echo $attributes['method'];?>" accept-charset='<?php echo $attributes['accept-charset'];?>' autocomplete='<?php echo $attributes['autocomplete'];?>'>
          <div class="container text-white">
            <div class="mb-4">
              <input
                    type="text"
                    id="user-name" name="username"
                                               placeholder="<?php echo $this->lang->line('Your Email') ?>" autocomplete='<?php echo $attributes['autocomplete'];?>' required
                  />
              <br />
            </div>
            <div>
              <input
                    type="password"
                    id="user-password" name="password"
                                               placeholder="<?php echo $this->lang->line('Your Password') ?>" autocomplete='<?php echo $attributes['autocomplete'];?>'
                    required
                  />
            </div>
			<?php if ($response) {
                                        echo '<div id="notify" class="alert alert-danger" >
                            <a href="#" class="close" data-dismiss="alert">&times;</a> <div class="message">' . $response . '</div>
                        </div>';
                                    } ?>
									<?php if ($this->aauth->get_login_attempts() > 1 && $captcha_on) {
                                        echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									<fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                                    </fieldset>';
                                    } ?>
            <div
                  class="mt-4 psw d-flex align-items-center d-inline-block w-100 small-font"
                >
              <input
                    style="width: auto"
                    class="remember-input chk-remember"
                    type="checkbox"
                    id="remember-me" name="remember_me"
                  />
              <label class="ml-2 forgot text-white m-0" for="remember-me"
                    ><?php echo "Remember Me"; ?></label
                  >
            </div>
            <button
                  type="submit"
                  class="btn mt-4 text-center w-100 login-button"
                > Login </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<script src="<?= assets_url(); ?>app-assets/vendors/js/vendors.min.js"></script>
<script type="text/javascript" src="<?= assets_url(); ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script type="text/javascript" src="<?= assets_url(); ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="<?= assets_url(); ?>app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="<?= assets_url(); ?>app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<script src="<?= assets_url(); ?>app-assets/js/core/app-menu.js"></script>
<script src="<?= assets_url(); ?>app-assets/js/core/app.js"></script>
<script type="text/javascript" src="<?= assets_url(); ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="<?= assets_url(); ?>app-assets/js/scripts/forms/form-login-register.js"></script>
