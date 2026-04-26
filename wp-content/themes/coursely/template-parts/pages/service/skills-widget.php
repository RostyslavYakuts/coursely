<?php
/**
 * Template part: Skills Widget
 */
?>
<div class="skills-widget-wrapper">
	<div class="skills-navigation">
		<ul>
			<li data-nav="skills" class="skill-item-js skill-item active"><span><i class="fa fa-certificate"></i>Our Skills</span></li>
			<li data-nav="mission" class="skill-item-js skill-item"><span ><i class="fa fa-bookmark"></i>Our Mission</span></li>
			<li data-nav="vision" class="skill-item-js skill-item"><span ><i class="fa fa-eye"></i>Our Vision</span></li>
		</ul>
	</div>
    <div class="skills-content">
        <div class="tab-content">
            <div class="tab-content-item-js tab-content-item active" data-tab-content="skills">
                <p><?php echo get_services_skills(); ?></p>
            </div>
            <div class="tab-content-item-js tab-content-item" data-tab-content="mission">
                <p><?php echo get_services_mission(); ?></p>
            </div>
            <div class="tab-content-item-js tab-content-item" data-tab-content="vision">
                <p><?php echo get_services_vision(); ?></p>
            </div>
        </div>
    </div>
</div>
