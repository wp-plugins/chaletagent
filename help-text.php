<?php

// This file is simply used to separate out the help text HTML content from the main PHP file.

?>

<h3>Usage</h3>

Currently you can publish the following information:

<table cellpadding="5">
	<thead>
		<tr>
			<th>Data Type</th>
			<th>Shortcode</th>
			<th>Template Tag</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Your prices and availability for a specified season</td>
			<td><code>[chaletagent_availability season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_template('availability', 1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Your guide prices for airport transfers for a specified season</td>
			<td><code>[chaletagent_transfers season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_template('transfers', 1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Publishable guest feedback testimonials</td>
			<td><code>[chaletagent_testimonials]</code></td>
			<td><code>&lt;?php echo chaletagent_template('testimonials'); ?&gt;</code></td>
		</tr>
		<tr>
			<td>The list of your seasons</td>
			<td><code>[chaletagent_seasons]</code></td>
			<td><code>&lt;?php echo chaletagent_template('seasons'); ?&gt;</code></td>
		</tr>
		<tr>
			<td>The list of your properties<br />(format can be 'table' or 'list')</td>
			<td><code>[chaletagent_properties format=list]</code></td>
			<td><code>&lt;?php echo chaletagent_template('properties', 'list'); ?&gt;</code></td>
		</tr>
		<tr>
			<td>Details of a specified property</td>
			<td><code>[chaletagent_properties property=1]</code></td>
			<td><code>&lt;?php echo chaletagent_template('properties', 1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>The list of available lift passes for a specified season</td>
			<td><code>[chaletagent_lift_passes season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_template('lift_passes', 1); ?&gt;</code></td>
		</tr>
		<tr>
			<td>The list of available lift passes grouped by type for a specified season</td>
			<td><code>[chaletagent_lift_pass_types season=1]</code></td>
			<td><code>&lt;?php echo chaletagent_template('lift_pass_types', 1); ?&gt;</code></td>
		</tr>
	</tbody>
</table>
