<?php

/**
 * Title: Main Product Category
 * Slug: multi-purpose/main-product-category
 */
$multi_purpose_pluginsList = get_option( 'active_plugins' );
$multi_purpose_plugin = 'woocommerce/woocommerce.php';
$multi_purpose_results = in_array( $multi_purpose_plugin , $multi_purpose_pluginsList);
if ( $multi_purpose_results )  {
?>

<!-- wp:group {"tagName":"main","className":"product-category-tp","style":{"spacing":{"margin":{"top":"3em","bottom":"3em"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<main class="wp-block-group product-category-tp" style="margin-top:3em;margin-bottom:3em"><!-- wp:gutentor/t2 {"gID":"g-7enuntw","gName":"gutentor/t2","pName":"gutentor/t2","t2Temp":1,"t2Taxonomy":"product_cat","t2Number":6,"tBtnTypography":{"fontType":"default","desktopFontSize":16,"tabletFontSize":16,"mobileFontSize":16,"textTransform":"normal"},"tFImgSize":"woocommerce_gallery_thumbnail","t2BgProps":{"size":"contain","pos":"top center","repeat":"no-repeat","attachment":"scroll"},"t2ContentM":{},"tBxAlign":{"desktop":"text-align-center"},"tBxC":{"enable":true,"normal":"#FFFFFF","hover":""},"tBxGt":{"normal":false,"hover":""},"tBxBr":{},"tBxP":{"type":"px","tTop":"15","tBottom":"15","mTop":"15","mBottom":"15"},"tTitleTag":"p","tTitleC":{"enable":true,"normal":"#000000","hover":""},"tTitleB":{"enable":false,"hover":""},"tTitleTypography":{"desktopFontSize":"13px","fontType":"google","googleFont":"Poppins","fontWeight":"600","tabletFontSize":"13px"},"tTitleM":{"dBottom":"0"},"tTitleP":{"dBottom":"0"},"tCountC":{"enable":true,"normal":"#000000","hover":""},"tCountTypography":{"fontType":"google","googleFont":"Poppins","fontWeight":"regular","desktopFontSize":"12px","tabletFontSize":"12px","mobileFontSize":"12px"},"tCountP":{"dTop":"4","dBottom":"0","tTop":"0","tBottom":"0"},"mBGType":"","mBGGradient":false,"mID":"my-category-tp","mContOnVAlign":true,"mPosTypeD":"g-pos-s","mPosOptD":"g-pos-custom","mOnHeight":true,"mHeight":{"type":"px","mobile":70,"tablet":70,"desktop":150}} /--></main>
<!-- /wp:group -->

<?php } else { ?>

<!-- wp:group {"tagName":"main","className":"product-category-tp","style":{"spacing":{"margin":{"top":"2em","bottom":"2em"}}},"layout":{"type":"constrained","contentSize":"85%"}} -->
<main class="wp-block-group product-category-tp" style="margin-top:2em;margin-bottom:2em"><!-- wp:columns {"className":"products-tabs-head","style":{"spacing":{"margin":{"bottom":"2em"},"blockGap":{"left":"0px"}}}} -->
<div class="wp-block-columns products-tabs-head" style="margin-bottom:2em"><!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fas fa-tv"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Electronics','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fas fa-vest"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Fashion','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fa-solid fa-kitchen-set"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Home &amp; Kitchen','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fa-solid fa-bottle-droplet"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Personal Care','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fas fa-leaf"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Groceries','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"18.3%"} -->
<div class="wp-block-column" style="flex-basis:18.3%"><!-- wp:group {"className":"cate-box tab-title active","style":{"spacing":{"padding":{"left":"12px","right":"12px","top":"7px","bottom":"7px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group cate-box tab-title active" style="padding-top:7px;padding-right:12px;padding-bottom:7px;padding-left:12px"><!-- wp:html -->
<i class="fas fa-mobile"></i>
<!-- /wp:html -->

<!-- wp:paragraph {"align":"center","className":"cate-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}},"typography":{"fontSize":"13px","textTransform":"capitalize","fontStyle":"Light","fontWeight":"600"},"spacing":{"padding":{"top":"5px","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"heading","fontFamily":"Poppins"} -->
<p class="has-text-align-center cate-title has-heading-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:5px;padding-right:0;padding-bottom:0;padding-left:0;font-size:13px;font-style:Light;font-weight:600;text-transform:capitalize"><a href="#"><?php esc_html_e('Mobile Accessories','multi-purpose'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"11px","fontStyle":"Regular","fontWeight":"400"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"},"padding":{"top":"0px","bottom":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center has-poppins-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0px;padding-bottom:0;font-size:11px;font-style:Regular;font-weight:400"><?php esc_html_e('02 Product','multi-purpose'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></main>
<!-- /wp:group -->


<?php } ?>