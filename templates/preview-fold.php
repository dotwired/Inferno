<a href="<?php the_permalink(); ?>" class="inferno-preview fold">
  <div class="panel panel1" style="background-image: url(<?php echo $this->image(); ?>);">
    <div class="overlay"></div>
  </div>
  <div class="panel panel2" style="background-image: url(<?php echo $this->image(); ?>);">
    <div class="overlay"></div>
  </div>
  <div class="panel panel3" style="background-image: url(<?php echo $this->image(); ?>);">
    <div class="overlay"></div>
  </div>
  <div class="panel panel4shadow"></div>
  <div class="panel panel4" style="background-image: url(<?php echo $this->image(); ?>);">
    <div class="overlay"></div>
  </div>
  <img src="<?php echo $this->image(); ?>" alt="" class="fallback" width="<?php echo $this->img_width; ?>" height="<?php echo $this->img_height; ?>" />
</a>