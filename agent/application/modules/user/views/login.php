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
        background-image: url('<?php echo base_url();?>agent-assets/images/backgrounds/bg.jpg');
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
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column bg-login">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div
      class="d-flex main-div align-items-center justify-content-center w-100 h-100"
    >
  <div class="row outer-content">
    <div class="col-md-6 d-md-block d-none left-section">
      <div
            class="content h-100 d-flex justify-content-center align-items-center"
          > <img
              class="store-image img-fluid"
              src="http://erp.zobox.in/userfiles/company/16088996411285771464.png"
              alt="logo"
            /> </div>
    </div>
    <div class="col-md-6 right-section text-white">
      <div
            class="content py-5 d-flex justify-content-between flex-column h-100"
          >
        <h5 class="card-title text-center mb-4 mb-lg-0"> Welcome ! </h5>
        <p class="text-center medium-font mb-4 mb-lg-0"> Sign in to your Account </p>
        <form  class="form-horizontal form-simple"  action="<?php echo base_url() . 'user/auth_user'; ?>" method="post">
         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
          <div class="container text-white">
            <div class="mb-4">
              <input type="text" id="email" name="email" placeholder="Email" autocomplete='<?php echo $attributes['autocomplete'];?>' required />
              <br />
            </div>
            <div>
              <input type="password" id="password" name="password"  placeholder="Password" autocomplete='<?php echo $attributes['autocomplete'];?>' required />
            </div>
            <?php if ($captcha_on) {
                                        echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									<fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="'.$captcha.'"></div>
                                    </fieldset>';
                                    } ?>
            <button type="submit" class="btn mt-4 text-center w-100 login-button"> Login </button>
          </div>
        </form>
		<?php    if ($this->common->front_end()->register) {
        ?> <br> <div class="row"><span class="col-xs-7"><a
                                                    href="<?php echo base_url('user/registration'); ?>" class="card-link">
                                               <?php echo $this->lang->line('Register')  ?></a></span><span class="col-xs-5"><a
                                                    href="<?php echo base_url('user/forgot'); ?>" class="card-link">
                                          <?php echo $this->lang->line('forgot_password')  ?>?</a></span></div>
                                <?php } ?>
      </div>
    </div>
  </div>
</div>
