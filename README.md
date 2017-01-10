# Magento2 ReCaptcha
Extension is integrate Google Recaptcha with your Magento2 store.

### Forgot Your Password page
<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/front.png" style="width:100%"/>
### Configuration page
<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/config.png" style="width:100%"/>
## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-re-captcha
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:static-content:deploy

