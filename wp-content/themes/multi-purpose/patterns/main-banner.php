<?php

/**
 * Title: Main Banner
 * Slug: multi-purpose/main-banner
 */
$multi_purpose_pluginsList = get_option( 'active_plugins' );
$multi_purpose_plugin = 'woocommerce/woocommerce.php';
$multi_purpose_results = in_array( $multi_purpose_plugin , $multi_purpose_pluginsList);
if ( $multi_purpose_results )  {
?>

<!-- wp:group {"className":"banner-sec","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"2em","bottom":"0"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group banner-sec" style="margin-top:2em;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"overlayColor":"primary","isUserOverlayColor":true,"minHeight":600,"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-cover" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;min-height:600px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"40%","className":"banner-left-col"} -->
<div class="wp-block-column is-vertically-aligned-center banner-left-col" style="flex-basis:40%"><!-- wp:group {"className":"slider-main-content","layout":{"type":"constrained"}} -->
<div class="wp-block-group slider-main-content"><!-- wp:paragraph {"className":"banner-top-text","style":{"typography":{"fontStyle":"Thin","fontWeight":"300","fontSize":"17px"}},"fontFamily":"Poppins"} -->
<p class="banner-top-text has-poppins-font-family" style="font-size:17px;font-style:Thin;font-weight:300"><?php esc_html_e('Shop Everything You Need, All in One Place','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"32px","lineHeight":1.6,"fontStyle":"ExtraLight","fontWeight":"700","letterSpacing":"1px"},"spacing":{"padding":{"top":"7px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"background","fontFamily":"Poppins"} -->
<h1 class="wp-block-heading has-background-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:7px;font-size:32px;font-style:ExtraLight;font-weight:700;letter-spacing:1px;line-height:1.6"><?php esc_html_e('Discover Top Deals Across Electronics, Fashion, Home Essentials &amp; More.','multi-purpose'); ?></h1>
<!-- /wp:heading -->

<!-- wp:buttons {"className":"slider-btn"} -->
<div class="wp-block-buttons slider-btn"><!-- wp:button {"backgroundColor":"background","textColor":"heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"textTransform":"uppercase","fontSize":"13px","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"left":"25px","right":"25px","top":"9px","bottom":"9px"}},"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"fontFamily":"Poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-heading-color has-background-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:9px;padding-right:25px;padding-bottom:9px;padding-left:25px;font-size:13px;font-style:Light;font-weight:600;text-transform:uppercase"><?php esc_html_e('shop now','multi-purpose'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"30%","className":"banner-middle-col"} -->
<div class="wp-block-column is-vertically-aligned-bottom banner-middle-col" style="flex-basis:30%"><!-- wp:group {"className":"banner-img-group","layout":{"type":"constrained"}} -->
<div class="wp-block-group banner-img-group"><!-- wp:image {"id":153,"width":"auto","height":"500px","sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-img.png'); ?>" alt="" class="wp-image-153" style="width:auto;height:500px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"banner-right-col"} -->
<div class="wp-block-column is-vertically-aligned-center banner-right-col" style="flex-basis:25%"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"className":"banner-product-box","layout":{"type":"constrained"}} -->
<div class="wp-block-group banner-product-box"><!-- wp:woocommerce/product-collection {"queryId":43,"query":{"perPage":8,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{"product_cat":[]},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"carousel","columns":6,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/by-category","hideControls":["inherit","hand-picked","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template {"className":"woo-prod-box","backgroundColor":"background","layout":{"type":"flex","justifyContent":"left","verticalAlignment":"top","flexWrap":"nowrap","orientation":"horizontal"}} -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"style":{"dimensions":{"aspectRatio":"auto"}}} /-->

<!-- wp:post-terms {"term":"product_cat","className":"prod-cat-name-top-banner","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","textTransform":"capitalize"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"5px","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} /-->

<!-- wp:post-title {"textAlign":"left","isLink":true,"className":"banner-right-profuct-title","style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontStyle":"Thin","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"textColor":"heading","fontSize":"medium","fontFamily":"Poppins","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:group {"className":"banner-product-bottom-rate-details","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group banner-product-bottom-rate-details"><!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center","textColor":"heading","fontSize":"small","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}}} /-->

<!-- wp:woocommerce/product-rating {"isDescendentOfQueryLoop":true,"textColor":"secondary","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}}} /--></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-gallery-large-image-next-previous {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"backgroundColor":"secondary","textColor":"background","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-woocommerce-product-gallery-large-image-next-previous"></div>
<!-- /wp:woocommerce/product-gallery-large-image-next-previous --></div>
<!-- /wp:group --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->

<?php } else { ?>

<!-- wp:group {"className":"banner-sec","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"2em","bottom":"0"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group banner-sec" style="margin-top:2em;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"overlayColor":"primary","isUserOverlayColor":true,"minHeight":600,"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-cover" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;min-height:600px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"40%","className":"banner-left-col"} -->
<div class="wp-block-column is-vertically-aligned-center banner-left-col" style="flex-basis:40%"><!-- wp:group {"className":"slider-main-content","layout":{"type":"constrained"}} -->
<div class="wp-block-group slider-main-content"><!-- wp:paragraph {"className":"banner-top-text","style":{"typography":{"fontStyle":"Thin","fontWeight":"300","fontSize":"17px"}},"fontFamily":"Poppins"} -->
<p class="banner-top-text has-poppins-font-family" style="font-size:17px;font-style:Thin;font-weight:300"><?php esc_html_e('Shop Everything You Need, All in One Place','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"32px","lineHeight":1.6,"fontStyle":"ExtraLight","fontWeight":"700","letterSpacing":"1px"},"spacing":{"padding":{"top":"7px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"background","fontFamily":"Poppins"} -->
<h1 class="wp-block-heading has-background-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:7px;font-size:32px;font-style:ExtraLight;font-weight:700;letter-spacing:1px;line-height:1.6"><?php esc_html_e('Discover Top Deals Across Electronics, Fashion, Home Essentials &amp; More.','multi-purpose'); ?></h1>
<!-- /wp:heading -->

<!-- wp:buttons {"className":"slider-btn"} -->
<div class="wp-block-buttons slider-btn"><!-- wp:button {"backgroundColor":"background","textColor":"heading","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"textTransform":"uppercase","fontSize":"13px","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"left":"25px","right":"25px","top":"9px","bottom":"9px"}},"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"8px","bottomRight":"8px"}}},"fontFamily":"Poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-heading-color has-background-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="border-top-left-radius:8px;border-top-right-radius:8px;border-bottom-left-radius:8px;border-bottom-right-radius:8px;padding-top:9px;padding-right:25px;padding-bottom:9px;padding-left:25px;font-size:13px;font-style:Light;font-weight:600;text-transform:uppercase"><?php esc_html_e('shop now','multi-purpose'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"30%","className":"banner-middle-col"} -->
<div class="wp-block-column is-vertically-aligned-bottom banner-middle-col" style="flex-basis:30%"><!-- wp:group {"className":"banner-img-group","layout":{"type":"constrained"}} -->
<div class="wp-block-group banner-img-group"><!-- wp:image {"id":153,"width":"auto","height":"500px","sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-img.png'); ?>" alt="" class="wp-image-153" style="width:auto;height:500px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"banner-right-col"} -->
<div class="wp-block-column is-vertically-aligned-center banner-right-col" style="flex-basis:25%"><!-- wp:group {"className":"owl-carousel","layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-group owl-carousel"><!-- wp:group {"className":"banner-product-box","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"12px","right":"12px"}},"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}},"backgroundColor":"background","layout":{"type":"constrained","justifyContent":"right"}} -->
<div class="wp-block-group banner-product-box has-background-background-color has-background" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:12px;padding-bottom:10px;padding-left:12px"><!-- wp:group {"className":"main-banner-prod-img","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group main-banner-prod-img" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":38,"width":"auto","height":"240px","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-product1.png'); ?>" alt="" class="wp-image-38" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;width:auto;height:240px"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"8px","bottom":"0px"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-top:8px;margin-bottom:0px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"banner-cate-top","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-cate-top has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Thin;font-weight:500"><?php esc_html_e('Electronic','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"banner-discount-top","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-discount-top has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Thin;font-weight:500"><?php esc_html_e('(25% Off)','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"className":"banner-right-profuct-title","style":{"typography":{"fontSize":"16px","fontStyle":"Thin","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0","right":"0","left":"0","bottom":"10px"}}},"fontFamily":"Poppins"} -->
<h2 class="wp-block-heading banner-right-profuct-title has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:10px;padding-left:0;font-size:16px;font-style:Thin;font-weight:700"><a href="#"><?php esc_html_e('Product Name Here','multi-purpose'); ?></a></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"banner-product-bottom-rate-details","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group banner-product-bottom-rate-details" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"banner-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"17px","fontStyle":"Thin","fontWeight":"600"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-main-price has-heading-color has-text-color has-link-color has-poppins-font-family" style="font-size:17px;font-style:Thin;font-weight:600"><?php esc_html_e('$ 99.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"banner-discount-price","style":{"elements":{"link":{"color":{"text":"#acacac"}}},"color":{"text":"#acacac"},"typography":{"fontSize":"13px"}},"fontFamily":"Poppins"} -->
<p class="banner-discount-price has-text-color has-link-color has-poppins-font-family" style="color:#acacac;font-size:13px"><?php esc_html_e('110.00','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"banner-rating-prod","style":{"spacing":{"blockGap":"5px","padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group banner-rating-prod" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:html -->
<i class="fas fa-star"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"border-first-rate","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0","bottom":"0","left":"5px","right":"5px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="border-first-rate has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:5px;padding-bottom:0;padding-left:5px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('4.5','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"rating-sec-text","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="rating-sec-text has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('533','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"banner-product-box","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px","left":"12px","right":"12px"}},"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}},"backgroundColor":"background","layout":{"type":"constrained","justifyContent":"right"}} -->
<div class="wp-block-group banner-product-box has-background-background-color has-background" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:12px;padding-bottom:10px;padding-left:12px"><!-- wp:group {"className":"main-banner-prod-img","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group main-banner-prod-img" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":38,"width":"auto","height":"240px","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-product2.png'); ?>" alt="" class="wp-image-38" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;width:auto;height:240px"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"8px","bottom":"0px"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-top:8px;margin-bottom:0px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"banner-cate-top","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-cate-top has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Thin;font-weight:500"><?php esc_html_e('Electronic','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"banner-discount-top","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-discount-top has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Thin;font-weight:500"><?php esc_html_e('(25% Off)','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"className":"banner-right-profuct-title","style":{"typography":{"fontSize":"16px","fontStyle":"Thin","fontWeight":"700"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0","right":"0","left":"0","bottom":"10px"}}},"fontFamily":"Poppins"} -->
<h2 class="wp-block-heading banner-right-profuct-title has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:10px;padding-left:0;font-size:16px;font-style:Thin;font-weight:700"><a href="#"><?php esc_html_e('Product Name Here','multi-purpose'); ?></a></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"banner-product-bottom-rate-details","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group banner-product-bottom-rate-details" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"spacing":{"blockGap":"5px","margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"banner-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"17px","fontStyle":"Thin","fontWeight":"600"}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="banner-main-price has-heading-color has-text-color has-link-color has-poppins-font-family" style="font-size:17px;font-style:Thin;font-weight:600"><?php esc_html_e('$ 99.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"banner-discount-price","style":{"elements":{"link":{"color":{"text":"#acacac"}}},"color":{"text":"#acacac"},"typography":{"fontSize":"13px"}},"fontFamily":"Poppins"} -->
<p class="banner-discount-price has-text-color has-link-color has-poppins-font-family" style="color:#acacac;font-size:13px"><?php esc_html_e('110.00','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"banner-rating-prod","style":{"spacing":{"blockGap":"5px","padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group banner-rating-prod" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:html -->
<i class="fas fa-star"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"border-first-rate","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0","bottom":"0","left":"5px","right":"5px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="border-first-rate has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:5px;padding-bottom:0;padding-left:5px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('4.5','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"rating-sec-text","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="rating-sec-text has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('533','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->

<?php } ?>