$(document).ready(function() {

            $("#frm-login").submit(function(e) {
                e.preventDefault();
                var emailTb = $('#email-tb');
                var pwTb = $('#password-tb');
                if (emailTb.val() && pwTb.val()) {
                    $('#login-fail-errmsg').addClass('hidden');
                    var url = $(this).attr('action');
                    var method = $(this).attr('method');
                    var data = $(this).serialize();
                    $.ajax({
                        url: url,
                        type: method,
                        data: data
                    }).done(function(data) {
                        if (data === "success") {
                            location.reload();
                        } else if (data === "fail") {
                            $('#login-fail-errmsg').removeClass('hidden');
                        }
                    });
                } else {
                    $('#login-fail-errmsg').removeClass('hidden');
                }

            });
        });