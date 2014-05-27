<a href="<?php the_permalink(); ?>" class="inferno-preview flip">
  <div class="front">
    <img src="<?php echo $this->image(); ?>" alt="<?php the_title(); ?>" width="<?php echo $this->img_width; ?>" height="<?php echo $this->img_height; ?>" />
  </div>
  <div class="back"></div>
</a>