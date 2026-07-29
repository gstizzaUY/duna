<?php

/**
 * Title: Product Sec
 * Slug: multi-purpose/product-sec
 */

$multi_purpose_pluginsList = get_option( 'active_plugins' );
$multi_purpose_plugin = 'woocommerce/woocommerce.php';
$multi_purpose_results = in_array( $multi_purpose_plugin , $multi_purpose_pluginsList);
if ( $multi_purpose_results )  {
?>

<!-- wp:group {"className":"product-sec","style":{"spacing":{"margin":{"top":"3em","bottom":"3em"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-group product-sec" style="margin-top:3em;margin-bottom:3em"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%","className":"prod-sec-left-col-main","style":{"typography":{"fontSize":"10px"}},"fontFamily":"Poppins"} -->
<div class="wp-block-column prod-sec-left-col-main has-poppins-font-family" style="font-size:10px;flex-basis:70%"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":300,"isDark":false,"className":"prod-left-col","style":{"border":{"radius":{"topLeft":"20px","topRight":"20px","bottomLeft":"20px","bottomRight":"20px"}},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"20px","bottom":"20px","left":"35px","right":"35px"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-cover is-light prod-left-col" style="border-top-left-radius:20px;border-top-right-radius:20px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-top:0;margin-bottom:0;padding-top:20px;padding-right:35px;padding-bottom:20px;padding-left:35px;min-height:300px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:woocommerce/product-collection {"queryId":49,"query":{"perPage":9,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{"product_cat":[]},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":1,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/by-category","hideControls":["inherit","hand-picked","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template {"className":"owl-carousel"} -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"400"}},"fontFamily":"Poppins"} -->
<p class="has-poppins-font-family" style="font-size:13px;font-style:Thin;font-weight:400"><?php esc_html_e('Headphone 30% Off','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-title {"textAlign":"left","isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontSize":"23px","fontStyle":"Thin","fontWeight":"700"}},"fontFamily":"Poppins","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:group {"className":"but-one-get-one-group","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group but-one-get-one-group"><!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"left","textColor":"heading","fontFamily":"Poppins","fontSize":"small","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontStyle":"Thin","fontWeight":"600"}}} /-->

<!-- wp:paragraph {"className":"left-discount-group","style":{"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"600"},"spacing":{"padding":{"top":"4px","bottom":"4px","left":"5px","right":"5px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"backgroundColor":"third-color","textColor":"heading","fontFamily":"Poppins"} -->
<p class="left-discount-group has-heading-color has-third-color-background-color has-text-color has-background has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:4px;padding-right:5px;padding-bottom:4px;padding-left:5px;font-size:10px;font-style:Thin;font-weight:600"><?php esc_html_e('Buy 1 Get 1 Freef','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"className":"prod-sec-content","style":{"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"400"}},"fontFamily":"Poppins"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"prod-section-img-box","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group prod-section-img-box" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"width":"300px","height":"300px","scale":"contain"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:woocommerce/product-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:woocommerce/product-collection --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":300,"isDark":false,"className":"prod-right-col","style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"20px","right":"20px"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"30px","topRight":"30px","bottomLeft":"30px","bottomRight":"30px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light prod-right-col" style="border-top-left-radius:30px;border-top-right-radius:30px;border-bottom-left-radius:30px;border-bottom-right-radius:30px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;min-height:300px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:woocommerce/product-collection {"queryId":9,"query":{"perPage":1,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":false,"taxQuery":{"product_cat":[]},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"list","columns":6,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/by-category","hideControls":["inherit","hand-picked","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."},"align":"wide"} -->
<div class="wp-block-woocommerce-product-collection alignwide"><!-- wp:woocommerce/product-template {"className":"woo-prod-box-bottom","layout":{}} -->
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"style":{"dimensions":{"aspectRatio":"auto"}}} /-->

<!-- wp:group {"className":"main-details-right-products-bttom","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group main-details-right-products-bttom" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"className":"rating-row-details","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group rating-row-details" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-title {"textAlign":"left","isLink":true,"className":"banner-right-profuct-title","style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0","right":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"lineHeight":"1.4","fontStyle":"Thin","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"textColor":"heading","fontSize":"medium","fontFamily":"Poppins","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-rating {"isDescendentOfQueryLoop":true,"textColor":"secondary","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"banner-product-bottom-rate-details","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group banner-product-bottom-rate-details" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center","textColor":"heading","fontFamily":"Poppins","fontSize":"small","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<?php } else { ?>

<!-- wp:group {"className":"product-sec","style":{"spacing":{"margin":{"top":"3em","bottom":"3em"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<div class="wp-block-group product-sec" style="margin-top:3em;margin-bottom:3em"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%","className":"prod-sec-left-col-main","style":{"typography":{"fontSize":"10px"}},"fontFamily":"Poppins"} -->
<div class="wp-block-column prod-sec-left-col-main has-poppins-font-family" style="font-size:10px;flex-basis:70%"><!-- wp:group {"className":"owl-carousel","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group owl-carousel" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":350,"isDark":false,"className":"prod-left-col","style":{"border":{"radius":{"topLeft":"20px","topRight":"20px","bottomLeft":"20px","bottomRight":"20px"}},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"20px","bottom":"20px","left":"35px","right":"35px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light prod-left-col" style="border-top-left-radius:20px;border-top-right-radius:20px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-top:0;margin-bottom:0;padding-top:20px;padding-right:35px;padding-bottom:20px;padding-left:35px;min-height:350px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","className":"prod-left-col","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center prod-left-col" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"head-discount-text","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"400"}},"fontFamily":"Poppins"} -->
<p class="head-discount-text has-poppins-font-family" style="font-size:13px;font-style:Thin;font-weight:400"><?php esc_html_e('Headphone 30% Off','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"23px","fontStyle":"Thin","fontWeight":"700","lineHeight":"1.4"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:23px;font-style:Thin;font-weight:700;line-height:1.4"><a href="#"><?php esc_html_e('Shop For Great Selection Of Headphone','multi-purpose'); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"but-one-get-one-group","style":{"spacing":{"margin":{"top":"2em","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group but-one-get-one-group" style="margin-top:2em;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"style":{"color":{"text":"#292929"},"elements":{"link":{"color":{"text":"#292929"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Poppins"} -->
<p class="has-text-color has-link-color has-poppins-font-family" style="color:#292929;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('$40.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"left-discount-group","style":{"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"600"},"spacing":{"padding":{"top":"4px","bottom":"4px","left":"5px","right":"5px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"backgroundColor":"third-color","textColor":"heading","fontFamily":"Poppins"} -->
<p class="left-discount-group has-heading-color has-third-color-background-color has-text-color has-background has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:4px;padding-right:5px;padding-bottom:4px;padding-left:5px;font-size:10px;font-style:Thin;font-weight:600"><?php esc_html_e('Buy 1 Get 1 Free','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"prod-sec-content","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"5px","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"400","lineHeight":1.4}},"fontFamily":"Poppins"} -->
<p class="prod-sec-content has-poppins-font-family" style="margin-top:5px;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:10px;font-style:Thin;font-weight:400;line-height:1.4"><?php esc_html_e('Lorem Ipsum is simply dummy text of the printing and typesetting industry.','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"id":88,"width":"300px","height":"300px","scale":"contain","sizeSlug":"full","linkDestination":"none","align":"left"} -->
<figure class="wp-block-image alignleft size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prod-left-img1.png'); ?>" alt="" class="wp-image-88" style="object-fit:contain;width:300px;height:300px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->

<!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":350,"isDark":false,"className":"prod-left-col","style":{"border":{"radius":{"topLeft":"20px","topRight":"20px","bottomLeft":"20px","bottomRight":"20px"}},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"20px","bottom":"20px","left":"35px","right":"35px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light prod-left-col" style="border-top-left-radius:20px;border-top-right-radius:20px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-top:0;margin-bottom:0;padding-top:20px;padding-right:35px;padding-bottom:20px;padding-left:35px;min-height:350px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","className":"prod-left-col","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center prod-left-col" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"head-discount-text","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"400"}},"fontFamily":"Poppins"} -->
<p class="head-discount-text has-poppins-font-family" style="font-size:13px;font-style:Thin;font-weight:400"><?php esc_html_e('Headphone 30% Off','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"23px","fontStyle":"Thin","fontWeight":"700","lineHeight":"1.4"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:23px;font-style:Thin;font-weight:700;line-height:1.4"><a href="#"><?php esc_html_e('Shop For Top Quality Choice Of Headphone','multi-purpose'); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"but-one-get-one-group","style":{"spacing":{"margin":{"top":"2em","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group but-one-get-one-group" style="margin-top:2em;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"style":{"color":{"text":"#292929"},"elements":{"link":{"color":{"text":"#292929"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Poppins"} -->
<p class="has-text-color has-link-color has-poppins-font-family" style="color:#292929;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('$40.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"left-discount-group","style":{"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"600"},"spacing":{"padding":{"top":"4px","bottom":"4px","left":"5px","right":"5px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"backgroundColor":"third-color","textColor":"heading","fontFamily":"Poppins"} -->
<p class="left-discount-group has-heading-color has-third-color-background-color has-text-color has-background has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:4px;padding-right:5px;padding-bottom:4px;padding-left:5px;font-size:10px;font-style:Thin;font-weight:600"><?php esc_html_e('Buy 1 Get 1 Free','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"prod-sec-content","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"5px","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"400","lineHeight":1.4}},"fontFamily":"Poppins"} -->
<p class="prod-sec-content has-poppins-font-family" style="margin-top:5px;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:10px;font-style:Thin;font-weight:400;line-height:1.4"><?php esc_html_e('Lorem Ipsum is simply dummy text of the printing and typesetting industry.','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"id":88,"width":"300px","height":"300px","scale":"contain","sizeSlug":"full","linkDestination":"none","align":"left"} -->
<figure class="wp-block-image alignleft size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prod-left-img2.png'); ?>" alt="" class="wp-image-88" style="object-fit:contain;width:300px;height:300px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover -->

<!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":350,"isDark":false,"className":"prod-left-col","style":{"border":{"radius":{"topLeft":"20px","topRight":"20px","bottomLeft":"20px","bottomRight":"20px"}},"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"20px","bottom":"20px","left":"35px","right":"35px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light prod-left-col" style="border-top-left-radius:20px;border-top-right-radius:20px;border-bottom-left-radius:20px;border-bottom-right-radius:20px;margin-top:0;margin-bottom:0;padding-top:20px;padding-right:35px;padding-bottom:20px;padding-left:35px;min-height:350px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"verticalAlignment":"center","className":"prod-left-col","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center prod-left-col" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"head-discount-text","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"400"}},"fontFamily":"Poppins"} -->
<p class="head-discount-text has-poppins-font-family" style="font-size:13px;font-style:Thin;font-weight:400"><?php esc_html_e('Headphone 30% Off','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"23px","fontStyle":"Thin","fontWeight":"700","lineHeight":"1.4"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:23px;font-style:Thin;font-weight:700;line-height:1.4"><a href="#"><?php esc_html_e('Shop For Premium Collection Of Headphone','multi-purpose'); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"but-one-get-one-group","style":{"spacing":{"margin":{"top":"2em","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group but-one-get-one-group" style="margin-top:2em;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"style":{"color":{"text":"#292929"},"elements":{"link":{"color":{"text":"#292929"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Poppins"} -->
<p class="has-text-color has-link-color has-poppins-font-family" style="color:#292929;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('$40.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"left-discount-group","style":{"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"600"},"spacing":{"padding":{"top":"4px","bottom":"4px","left":"5px","right":"5px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"backgroundColor":"third-color","textColor":"heading","fontFamily":"Poppins"} -->
<p class="left-discount-group has-heading-color has-third-color-background-color has-text-color has-background has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:4px;padding-right:5px;padding-bottom:4px;padding-left:5px;font-size:10px;font-style:Thin;font-weight:600"><?php esc_html_e('Buy 1 Get 1 Free','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"prod-sec-content","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"5px","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"10px","fontStyle":"Thin","fontWeight":"400","lineHeight":1.4}},"fontFamily":"Poppins"} -->
<p class="prod-sec-content has-poppins-font-family" style="margin-top:5px;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:10px;font-style:Thin;font-weight:400;line-height:1.4"><?php esc_html_e('Lorem Ipsum is simply dummy text of the printing and typesetting industry.','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"id":88,"width":"300px","height":"300px","scale":"contain","sizeSlug":"full","linkDestination":"none","align":"left"} -->
<figure class="wp-block-image alignleft size-full is-resized"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prod-left-img3.png'); ?>" alt="" class="wp-image-88" style="object-fit:contain;width:300px;height:300px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"30%"} -->
<div class="wp-block-column" style="flex-basis:30%"><!-- wp:cover {"customOverlayColor":"#f6f6f6","isUserOverlayColor":true,"minHeight":350,"isDark":false,"className":"prod-right-col","style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"20px","right":"20px"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":{"topLeft":"30px","topRight":"30px","bottomLeft":"30px","bottomRight":"30px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light prod-right-col" style="border-top-left-radius:30px;border-top-right-radius:30px;border-bottom-left-radius:30px;border-bottom-right-radius:30px;margin-top:0;margin-bottom:0;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;min-height:350px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim" style="background-color:#f6f6f6"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"right-img-box","layout":{"type":"constrained"}} -->
<div class="wp-block-group right-img-box"><!-- wp:image {"id":90,"width":"200px","height":"200px","scale":"contain","sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full is-resized"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prod-right-img.png'); ?>" alt="" class="wp-image-90" style="object-fit:contain;width:200px;height:200px"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"right-discount-text","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group right-discount-text" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"right-dis-inner-text","style":{"spacing":{"padding":{"top":"2px","bottom":"2px","left":"5px","right":"5px"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"11px","fontStyle":"Thin","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"border":{"radius":{"topLeft":"3px","topRight":"3px","bottomLeft":"3px","bottomRight":"3px"}}},"backgroundColor":"third-color","textColor":"heading","fontFamily":"Poppins"} -->
<p class="right-dis-inner-text has-heading-color has-third-color-background-color has-text-color has-background has-link-color has-poppins-font-family" style="border-top-left-radius:3px;border-top-right-radius:3px;border-bottom-left-radius:3px;border-bottom-right-radius:3px;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:2px;padding-right:5px;padding-bottom:2px;padding-left:5px;font-size:11px;font-style:Thin;font-weight:600"><?php esc_html_e('15% Off','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"main-details-right-products-bttom","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group main-details-right-products-bttom"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"className":"rating-row-details","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group rating-row-details" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:heading {"level":3,"style":{"typography":{"textTransform":"capitalize","fontSize":"15px","fontStyle":"ExtraLight","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"5px","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<h3 class="wp-block-heading has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:5px;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:ExtraLight;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Smart Headphone','multi-purpose'); ?></h3></a>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"blockGap":"5px","padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:html -->
<i class="fas fa-star"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"className":"border-first-rate","style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0","bottom":"0","left":"4px","right":"4px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="border-first-rate has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:4px;padding-bottom:0;padding-left:4px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('4.8','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"13px","fontStyle":"Thin","fontWeight":"500","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0px","left":"1px","right":"1px"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-right:1px;padding-bottom:0px;padding-left:1px;font-size:13px;font-style:Thin;font-weight:500;line-height:1"><?php esc_html_e('5k','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"product-sec-right-disc-box","layout":{"type":"constrained","justifyContent":"right"}} -->
<div class="wp-block-group product-sec-right-disc-box"><!-- wp:paragraph {"align":"right","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"color":{"text":"#b4b4b4"},"elements":{"link":{"color":{"text":"#b4b4b4"}}},"typography":{"fontSize":"11px","fontStyle":"Light","fontWeight":"500"}},"fontFamily":"Poppins"} -->
<p class="has-text-align-right has-text-color has-link-color has-poppins-font-family" style="color:#b4b4b4;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:11px;font-style:Light;font-weight:500"><?php esc_html_e('$38.00','multi-purpose'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"right","style":{"typography":{"fontStyle":"Thin","fontWeight":"500","fontSize":"18px"},"elements":{"link":{"color":{"text":"#292929"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"color":{"text":"#292929"}},"fontFamily":"Poppins"} -->
<p class="has-text-align-right has-text-color has-link-color has-poppins-font-family" style="color:#292929;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:18px;font-style:Thin;font-weight:500"><?php esc_html_e('$30.00','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<?php } ?>