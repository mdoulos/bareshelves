<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$listsPresent = false;
$hasZoomableImages = true;

$product_id = get_the_ID(); ?>

<figure class="woocommerce-product-gallery__wrapper">

	<div class="woocommerce-product-gallery__image-section">
		<?php
		if ($post_thumbnail_id && ($attachment_ids && $product->get_image_id())) { 
			$image_ids = array_merge([$post_thumbnail_id], $attachment_ids);
			$video = get_field('video_autoplay_mp4');
			$thumbnail = get_field('video_autoplay_thumbnail'); 

			// Loop through all primary product images.
			$itemNumber = 0;
			$htmlPrimaryImages = '';
			foreach ($image_ids as $image_id) {
				$itemNumber++;
				$primarySource = wp_get_attachment_image_src($image_id, array('700', '600'), false, '');
				$hiddenClass = ($itemNumber != 1) ? "hidden" : "";
				if ($itemNumber == 1 && $video) { $hiddenClass = "hidden"; }
				$htmlPrimaryImages .= '<figure class="wc-product-gallery-primary ' . $hiddenClass . '" id="primaryItemNum' . $itemNumber .'"><img class= "woocommerce-product-gallery__image-primary" src="' . $primarySource[0] . '"/></figure>';
			}
			
			if ($video) {
				$itemNumber++;

				$htmlPrimaryImages .= '<figure class="product-page-video-demo wc-product-gallery-primary" id="primaryItemNum' . $itemNumber .'"><div class="product-page-video-demo-container"><video autoplay muted playsinline loop><source src="' . $video . '" type="video/mp4">Your browser does not support the video tag.</video></div></figure>';
				
				?>

			<?php
			} 

			// Loop through all product image thumbnails.
			$itemNumber = 0;
			$htmlThumbnails  = '<ul class="woocommerce-product-gallery__image-thumbnail-list" id="thumbnailImageList">';
			foreach ($image_ids as $image_id) {
				$itemNumber++;
				
				$thumbnailSource = wp_get_attachment_image_src($image_id, array('42', '42'), false, '');
				$htmlThumbnails .= '<li onclick="showCorrespondingImage(' . $itemNumber . ')" class="woocommerce-product-gallery__image-thumbnail thumbnail-id-'. $image_id .'" id="thumbnailItemNum' . $itemNumber . '"><img src="' . $thumbnailSource[0] . '"/></li>';
			}

			$video = get_field('video_autoplay_mp4');
			$thumbnailSource = get_field('video_autoplay_thumbnail');

			if ($video) {
				$itemNumber++;

				$htmlThumbnails .= '<li onclick="showCorrespondingImage(' . $itemNumber . ')" class="wc-product-gallery-autoplay-video wc-product-gallery-video woocommerce-product-gallery__image-thumbnail thumbnail-id-'. $image_id .'" id="thumbnailItemNum' . $itemNumber . '"><img src="' . $thumbnailSource . '"/><img class="wc-gallery-video-thumbnail" src="yourwebsiteurl-Play-Button-Transparent.png"/></li>';
			}

			$htmlThumbnails .= '</ul>';
			$listsPresent = true;
			
		} else if ( $post_thumbnail_id ) {

			// If there is just 1 product image.

			$primarySource = wp_get_attachment_image_src( $post_thumbnail_id, array('700', '600'), false, '' );
			
			$htmlPrimaryImages = '<img class="woocommerce-product-gallery__image-primary" src="' . $primarySource[0] . '"/>';

			$hasZoomableImages = false;

			
		} else {

			// If there is no product image, output a default image.
			$htmlPrimaryImages  = '<div class="woocommerce-product-gallery__image--placeholder wc-gallery-active-image">';
			$htmlPrimaryImages .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$htmlPrimaryImages .= '</div>';

			$hasZoomableImages = false;

		}
		echo '<div class="sticky-image-container">';
			if ($hasZoomableImages) {
				echo '<div class="img-magnifier-container">';
					echo $htmlPrimaryImages;
					
					echo '<div class="woocommerce-product-gallery__zoomicon">🔍</div>';
				echo '</div>';
				echo '<p class="single-product-rollover">Roll over image to zoom in</p>';
			} else {
				echo $htmlPrimaryImages;
			}
		echo '</div>';
		?>
	</div>

	<?php
		if ($listsPresent) {
			?>
			<div class="woocommerce-product-gallery__thumbnail-section">
				<?php echo $htmlThumbnails; // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
			</div>
			<script>
				var thumbnailImageList = Array.from(document.getElementById("thumbnailImageList").children);
				var primaryImageList = Array.from(document.getElementsByClassName("wc-product-gallery-primary"));
				var magnifyingGlassIcon = document.querySelector('.woocommerce-product-gallery__zoomicon');
				var zoomMessage = document.querySelector('.single-product-rollover');

				function makeThumbnailInactive(item) {
					item.classList.remove("wc-gallery-active-thumbnail");
				}
				function hidePrimaryImage(item) {
					item.classList.add("hidden");
				}

				function showCorrespondingImage(listItemNumber) {
					thumbnailImageList.forEach(makeThumbnailInactive);
					primaryImageList.forEach(hidePrimaryImage);

					var thumbnailImage = document.getElementById("thumbnailItemNum" + listItemNumber);
					thumbnailImage.classList.add("wc-gallery-active-thumbnail");

					var primaryImage = document.getElementById("primaryItemNum" + listItemNumber);
					primaryImage.classList.remove("hidden");

					if (primaryImage.classList.contains("product-page-video-demo")) {
						magnifyingGlassIcon.classList.add("hidden");
						zoomMessage.classList.add("hidden");
					} else {
						magnifyingGlassIcon.classList.remove("hidden");
						zoomMessage.classList.remove("hidden");
					}
				}

				function magnify(imgID, zoom) {
					if(!('ontouchstart' in window)) {
						var img, figure, glass, w, h, bw;
						figure = document.getElementById(imgID);
						img = figure.querySelector('img:first-child');

						/* Create magnifier glass: */
						glass = document.createElement("DIV");
						glass.setAttribute("class", "img-magnifier-glass");
						glass.style.display = "none";

						/* Insert magnifier glass: */
						img.parentElement.insertBefore(glass, img);

						/* Show the magnifier glass when the mouse cursor is over the image: */
						img.addEventListener("mouseover", function() {
							glass.style.display = "block";

							/* Set background properties for the magnifier glass: */
							glass.style.backgroundImage = "url('" + img.src + "')";
							glass.style.backgroundRepeat = "no-repeat";
							glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
							bw = 3;
							w = glass.offsetWidth / 2;
							h = glass.offsetHeight / 2;
						});

						/* Execute a function when someone moves the magnifier glass over the image: */
						glass.addEventListener("mousemove", moveMagnifier);
						img.addEventListener("mousemove", moveMagnifier);

						glass.addEventListener("mouseout", function() {
							glass.style.display = "none";
						});

						function moveMagnifier(e) {
							var pos, x, y;
							/* Prevent any other actions that may occur when moving over the image */
							e.preventDefault();

							/* Get the cursor's x and y positions: */
							pos = getCursorPos(e);
							x = pos.x;
							y = pos.y;

							/* Prevent the magnifier glass from being positioned outside the image: */
							if (x > img.width - (w / zoom) - 50) {x = img.width - (w / zoom) - 50;}
							if (x < w / zoom + 50) {x = w / zoom + 50;}
							if (y > img.height - (h / zoom) - 40) {y = img.height - (h / zoom) - 40;}
							if (y < h / zoom + 40) {y = h / zoom + 40;}

							/* Display what the magnifier glass "sees": */
							glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";

							/* Set the position of the magnifier glass: */
							glass.style.left = (x - w) + "px";
							glass.style.top = (y - h) + "px";

							/* Display what the magnifier glass "sees": */
							glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
						}

						function getCursorPos(e) {
							var a, x = 0, y = 0;
							e = e || window.event;
							/* Get the x and y positions of the image: */
							a = img.getBoundingClientRect();
							/* Calculate the cursor's x and y coordinates, relative to the image: */
							x = e.pageX - a.left;
							y = e.pageY - a.top;
							/* Consider any page scrolling: */
							x = x - window.pageXOffset;
							y = y - window.pageYOffset;
							return {x : x, y : y};
						}
					}
				}

				const ul = document.getElementById("thumbnailImageList");
				const listItems = ul.getElementsByTagName("li");

				// Create a new array to store only the list items that do not have the class "wc-product-gallery-video"
				const filteredListItems = [];
				for (let i = 0; i < listItems.length; i++) {
					if (!listItems[i].classList.contains("wc-product-gallery-video")) {
						filteredListItems.push(listItems[i]);
					}
				}

				// Loop through the filtered list items and attach the magnify function to the corresponding primary item
				for (let i = 0; i < filteredListItems.length; i++) { 
					const thumbnailItemNum = filteredListItems[i].id.replace("thumbnailItemNum", "");
					const primaryItemNum = `primaryItemNum${thumbnailItemNum}`;
					magnify(primaryItemNum, 2);
				}

				var video = document.querySelector('.product-page-video-demo-container video');

				if (video) {
					video.addEventListener('click', function() {
						if (video.paused) {
							video.play();
						} else {
							video.pause();
						}
					});
					video.controls = false;
					
					magnifyingGlassIcon.classList.add("hidden");
					zoomMessage.classList.add("hidden");
				}

			</script>
			<?php
		}
		?>
</figure>
