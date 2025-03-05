# Magento 2 Flixmedia Integration

This Magento 2 module integrates Flixmedia services into your store, enabling product syndication, tracking pixels, video syndication, AR content, and image optimization.

## Installation

### Using Composer

```
composer require studioraz/magento2-flixmedia
```

```sh
cd <magento_root>
bin/magento module:enable SR_Flixmedia
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

## Configuration

1. Log in to Magento Admin Panel.
2. Navigate to **Stores > Configuration > Studio Raz > Flixmedia**.
3. Configure the following settings:
   - **Enable Flixmedia**: Enable or disable the integration.
   - **Distributor ID**: Enter the Distributor ID provided by Flixmedia.
4. Click **Save Config**

## Production Configuration

1. Go to **Catalog > Products** and select a product to edit.
2. Find the **Flixmedia** section and expand it.
3. Enable Flixmedia for the product.
4. Set either **MPN (Manufacturer Part Number)** or **EAN (European Article Number)**.
5. Choose the **Brand**.
6. Save the product.
7. Visit the product page on the frontend and verify that Flixmedia content is loaded successfully.

## Support

If you encounter any problems or bugs, please open an issue on [https://github.com/studioraz/magento2-flixmedia/issues).

Need help setting up or want to customize this extension to meet your business needs? Please email support@studioraz.co.il and if we like your idea we will add this feature for free or at a discounted rate.

## License

This module is licensed under the MIT License.


