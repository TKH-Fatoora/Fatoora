
<?php

use Gregwar\Captcha\CaptchaBuilder;

$builder = new CaptchaBuilder;
$builder->build();

header('Content-type: image/jpeg');
$builder->output();

?>
<img src="<?php echo $builder->inline(); ?>" />
