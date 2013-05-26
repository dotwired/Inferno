<div class="preview-box type-post <?php echo $width . $lastclass; ?>">
    <h3><?php the_title(); ?></h3>
    <?php echo inferno_preview( false, $img_width, $img_height, $effect, true ); ?>
    <?php the_excerpt(); ?>
</div>