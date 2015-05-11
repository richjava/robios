<div class="container">
    <div id="main-wrapper">
        <div id="signup-wrapper" class="col-md-6 center">
            <h1><i class="fa fa-user-plus"></i> Create an Account</h1>
            <?php
            //success message
            if ($this->session->flashdata('success')):
                ?>
                <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                <div id="msg-wrapper">
                    <h1><i class="fa fa-check"></i></h1>
                    <p>Thanks for signing up!</p>
                    <p class="blurb"> You now have access to the Robios dashboard.</p>
                    <div style="text-align: center">
                        <a href="<?php echo base_url(); ?>dashboard" class="btn btn-lg btn-success" style="margin:0 auto;"><i class="fa fa-plus-square"></i> Go to Dashboard</a>
                    </div>
                </div>

                <?php
            elseif ($token):
                ?>
                <h2><?php echo $token->organisation_name ?></h2>
                <?php
                //error message
                if ($this->session->flashdata('error')):
                    ?>
                    <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
                    <div id="msg-wrapper">
                        <h1><i class="fa fa-frown-o"></i></h1>
                        <p>There was an error</p>
                        <p class="blurb">Please try again or contact the site administrator.</p>
                        <a href="site#contact" class="btn btn-lg btn-success">Contact Us</a>
                    </div>
                <?php else: ?>
                    <p style='margin-bottom:30px;'>Please fill in the form to gain access to the Robios dashboard.</p>
                    <?php echo validation_errors('<div class="alert alert-danger">', "</div>"); ?>
                    <?php echo form_open('auth/create_user/'.$token->token); ?>
                    <!--                    <div class="form-group">
                                            <label for="first_name">Authorization key</label>
                    <?php
//                        $fn_data = array(
//                            'name' => 'first_name',
//                            'value' => set_value('first_name'),
//                            'placeholder' => 'Paste the key you were given for registration',
//                            'class' => 'form-control'
//                        );
//                        echo form_input($fn_data);
                    ?>
                                        </div>-->
                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <?php
                        $fn_data = array(
                            'name' => 'first_name',
                            'value' => set_value('first_name'),
                            'placeholder' => 'First name',
                            'class' => 'form-control'
                        );
                        echo form_input($fn_data);
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last name</label>
                        <?php
                        $ln_data = array(
                            'name' => 'last_name',
                            'value' => set_value('last_name'),
                            'placeholder' => 'Last name',
                            'class' => 'form-control'
                        );
                        echo form_input($ln_data);
                        ?>
                    </div>

                    <!--                    <div class="form-group">
                                            <label for="business_name">Business Name</label>
                    <?php
//                        $ln_data = array(
//                            'name' => 'business_name',
//                            'value' => set_value('business_name'),
//                            'placeholder' => 'This is the display name of your business',
//                            'class' => 'form-control'
//                        );
//                        echo form_input($ln_data);
                    ?>
                                        </div>-->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <?php
                        $email_data = array(
                            'name' => 'email',
                            'value' => set_value('email'),
                            'placeholder' => 'Email',
                            'class' => 'form-control',
                            'type' => 'email'
                        );
                        echo form_input($email_data);
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <?php
                        $pw_data = array(
                            'name' => 'password',
                            'value' => set_value('password'),
                            'placeholder' => 'Password',
                            'class' => 'form-control'
                        );
                        echo form_password($pw_data);
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="password2">Confirm Password</label>
                        <?php
                        $pw2_data = array(
                            'name' => 'password2',
                            'value' => set_value('password2'),
                            'placeholder' => 'Confirm password',
                            'class' => 'form-control'
                        );
                        echo form_password($pw2_data);
                        ?>
                    </div>
                    <?php if ($token->organisation_id != null): ?>
                        <input type="hidden" name="organisation_id" value="<?php echo $token->organisation_id ?>"/>
                    <?php endif; ?>
                    <input type="hidden" name="organisation_name" value="<?php echo $token->organisation_name ?>"/>
                    <input type="hidden" name="token" value="<?php echo $token->token ?>"/>
                    <button type="submit" type="save" class="btn btn-primary">
                        <i class="fa fa-user-plus"></i> Create Account
                    </button>

                   
                    <?php echo form_close() ?>

                <?php
                endif;
            else://not authorized
                ?>
                <p>Sorry, you are not authorized to create a new account.</p>
                <p>This may be because you haven't come to this page through a special link or your account may have already been set up.</p>
                <p class="blurb">If you'd like to create a Robios account or think this message is in error please contact the site administrator.</p>
                <div style="text-align: center">
                    <a href="<?php echo base_url(); ?>#contact" class="btn btn-lg btn-success" style="margin:0 auto;"><i class="fa fa-envelope"></i> Contact Us</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>