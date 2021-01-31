# Magento2 ReCaptcha

[![Total Downloads](https://poser.pugx.org/faonni/module-re-captcha/downloads)](https://packagist.org/packages/faonni/module-re-captcha)
[![Latest Stable Version](https://poser.pugx.org/faonni/module-re-captcha/v/stable)](https://packagist.org/packages/faonni/module-re-captcha)

Extension is integrate Google Recaptcha with your Magento2 store.

### Forgot Your Password page

<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/front.png" style="width:100%"/>

### Admin Login page

<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/admin.png" style="width:100%"/>

## Compatibility

Magento CE(EE) 2.0.x, 2.1.x, 2.2.x, 2.3.x, 2.4.x

## Install

#### Install via Composer (recommend)

1. Go to Magento2 root folder

2. Enter following commands to install module:

     For Magento CE(EE) 2.0.x, 2.1.x, 2.2.x, 2.3.x

    ```bash
    composer require faonni/module-re-captcha:2.0.*
    ```
     For Magento CE (EE) 2.4.x

    ```bash
    composer require faonni/module-re-captcha:2.4.*
    ```
   Wait while dependencies are updated.

#### Manual Installation

1. Create a folder {Magento root}/app/code/Faonni/ReCaptcha

2. Download the corresponding [latest version](https://github.com/karliuka/m2.ReCaptcha/releases)

3. Copy the unzip content to the folder ({Magento root}/app/code/Faonni/ReCaptcha)

#### Completion of installation

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy  (optional)
    ```
### Configuration Frontend

In the Magento Admin Panel go to *Stores > Configuration > Customers > Customer Configuration > ReCAPTCHA*.

<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/config.png" style="width:100%"/>

### Configuration Backend

In the Magento Admin Panel go to *Stores > Configuration > Advanced > Admin > ReCAPTCHA*.

<img alt="Magento2 ReCaptcha" src="https://karliuka.github.io/m2/re-captcha/config-admin.png" style="width:100%"/>

## Uninstall
This works only with modules defined as Composer packages.

#### Remove database data

1. Go to Magento2 root folder

2. Enter following commands to remove database data:

    ```bash
    php bin/magento module:uninstall -r Faonni_ReCaptcha
    ```
#### Remove Extension

1. Go to Magento2 root folder

2. Enter following commands to remove:

    ```bash
    composer remove faonni/module-re-captcha
    ```

#### Completion of uninstall

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy  (optional)
    ```