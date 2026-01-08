<html>
<body>
    <p> Dear Customer</p>
    <p>A new password was requested for your Bizadmin staff account.</p>
    <p>To reset your password, please click on the link below:</p>

	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
<p>Kind regards,</p>
<p> Bizadmin</p>
</body>
</html>