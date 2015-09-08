<?php

use Behat\Behat\Context\Step;

/**
 * Category context.
 */
class ProductContext extends MagentoProjectContext
{
    protected $_product = null;

    public function __construct()
    {
        $this->_product = $this->getRandomProduct();
    }

    /**
     * @Given /^I am on a product page$/
     */
    public function iAmOnAProductPage()
    {
        $url = $this->getMinkParameter('base_url') . 'catalog/product/view/id/' . $this->_product->getId();
        $this->getSession()->visit($url);
    }

    /**
     * @Then /^I should see the product name$/
     */
    public function iShouldSeeTheProductName()
    {
        $this->getMainContext()->assertElementContainsText('h1', $this->_product->getName());
    }

    /**
     * @Given /^I should see a valid product image$/
     */
    public function iShouldSeeAValidProductImage()
    {
        $productParams = $this->getMainContext()->getParameter('product');
        $selector = $productParams['image']['selector'];
        $image = $this->getSession()->getPage()->find('css', $selector);
        assertNotContains('placeholder', $image->getAttribute('src'));
    }

    /**
     * @When /^I click the add to cart button$/
     */
    public function iClickTheAddToCartButton()
    {
        $this->getSession()->getDriver()->click('//button[@onclick="productAddToCartForm.submit(this)"]');
    }

    /**
     * @Then /^I should be on the cart page$/
     */
    public function iShouldBeOnTheCartPage()
    {
        assertNotNull($this->find('xpath','//h1[contains(., "Shopping Cart")]'));
        $this->getMainContext()->assertPageAddress('/checkout/cart/');
    }
}
