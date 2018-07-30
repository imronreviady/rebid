<?php if ($friendrequest->num_rows() > 0) : ?>
	<?php foreach ($friendrequest->result() as $row) : ?> 
		<li>
			<div class="author-thumb">
				<img src="<?=$this->core_model->get_image_url('user' , $row->user_id)?>" alt="author" width="34">
			</div>
			<div class="notification-event">
				<a href="#" class="h6 notification-friend"><?=$row->first_name?> <?=$row->last_name?></a>
				<span class="chat-message-item">Mutual Friend: Sarah Hetfield</span>
			</div>
			<span class="notification-icon">
				<a href="#" class="accept-request">
					<span class="icon-add without-text">
						<svg class="olymp-happy-face-icon"><use xlink:href="<?=base_url()?>assets/frontend/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
					</span>
				</a>
				<a href="#" class="accept-request request-del">
					<span class="icon-minus">
						<svg class="olymp-happy-face-icon"><use xlink:href="<?=base_url()?>assets/frontend/svg-icons/sprites/icons.svg#olymp-happy-face-icon"></use></svg>
					</span>
				</a>
			</span>
			<div class="more">
				<svg class="olymp-three-dots-icon"><use xlink:href="<?=base_url()?>assets/frontend/svg-icons/sprites/icons.svg#olymp-three-dots-icon"></use></svg>
			</div>
		</li>
	<?php endforeach; ?>
<?php endif; ?>