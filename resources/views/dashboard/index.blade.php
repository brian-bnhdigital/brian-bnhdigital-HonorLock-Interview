@extends('layouts.app')


@section('title', $title)

@push('css')
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Quicksand" />
	<link rel="stylesheet" type="text/css" href="https://warfares.github.io/pretty-json/css/pretty-json.css" />
	<style>
		.darkBkg{
			background-color: #55595c;
			color:#fff;
		}
		.album .row + .row{
			margin-top: 1rem;
		}
	</style>
@endpush

@push('js')
	<script type="text/javascript" src="https://warfares.github.io/pretty-json/libs/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="https://warfares.github.io/pretty-json/libs/underscore-min.js"></script>
	<script type="text/javascript" src="https://warfares.github.io/pretty-json/libs/backbone-min.js"></script>
	<script type="text/javascript" src="https://warfares.github.io/pretty-json/pretty-json-min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/js/app.js"></script>
@endpush
@section('content')
<main>
	<section class="py-5 text-center container">
		<div class="row py-lg-5">
			<div class="col-lg-10 col-md-8 mx-auto">
				<h1 class="fw-light">{{ $title }}</h1>
				<p class="lead text-muted">Below is a quick description of the results.</p>
			</div>
		</div>
	</section>
	<div class="album py-5 bg-light">
		<div class="container">
			<div class="row row-cols-1 row-cols-lg-1 g-1 g-lg-1">
				<div class="col">
					<div class="card">
						<div class="card-header darkBkg">
							Results:
						</div>
						<div class="card-body">
							<p class="card-text">
								If the script found new vehicles not in the database they will be displayed in the "new_vehicles_added" array and success response will be true.
								<br />
								Any vehicles that were already in the database are in the "existing_vehicles_found" array.
							</p>
							<span id="result"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-lg-2 gy-3 gx-4">
				<div class="col">
					<div class="card shadow-sm">
						<div class="card-header darkBkg">
							<div class="card-text">
								Database Schema:
							</div>
						</div>
						<div class="card-body">
							<p class="card-text">The create schema that is generated using the "illuminate/database" package is:</p>
							<div class="d-flex justify-content-between align-items-center">
								<p class="">
									<span class="text-primary">CREATE DATABASE IF NOT EXISTS</span> <span class="text-danger">`consumers_edge_interview`</span>;
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card shadow-sm">
						<div class="card-header darkBkg">
							<div class="card-text">
								Table Schema:
							</div>
						</div>
						<div class="card-body">
							<p class="card-text">The table schema that is generated with "illuminate/database" package is:</p>
							<div class="d-flex justify-content-between align-items-center">
								<p class="">
									<span class="text-primary">CREATE TABLE</span> <span class="text-danger">`vehicles`</span> (<br />
									<span class="text-danger">`id`</span> bigint unsigned <span class="text-primary">NOT NULL AUTO_INCREMENT</span>,<br />
									<span class="text-danger">`make`</span> <span class="text-primary">varchar</span>(<span class="text-warning">255</span>) <span class="text-primary">COLLATE</span> utf8_unicode_ci <span class="text-primary">DEFAULT NULL</span>,<br />
									<span class="text-danger">`mileage`</span> <span class="text-primary">int unsigned DEFAULT NULL</span>,<br />
									<span class="text-danger">`model`</span> <span class="text-primary">varchar</span>(<span class="text-warning">255</span>) <span class="text-primary">COLLATE</span> utf8_unicode_ci <span class="text-primary">DEFAULT NULL</span>,<br />
									<span class="text-danger">`price`</span> <span class="text-primary">int unsigned DEFAULT NULL</span>,<br />
									<span class="text-danger">`vehicle_id`</span> <span class="text-primary">int unsigned NOT NULL</span>,<br />
									<span class="text-danger">`vin`</span> <span class="text-primary">varchar</span>(<span class="text-warning">255</span>) <span class="text-primary">COLLATE</span> utf8_unicode_ci <span class="text-primary">NOT NULL</span>,<br />
									<span class="text-danger">`created_at`</span> <span class="text-primary">timestamp NULL DEFAULT NULL</span>,<br />
									<span class="text-danger">`updated_at`</span> <span class="text-primary">timestamp NULL DEFAULT NULL</span>,<br />
									<span class="text-primary">PRIMARY KEY</span> (<span class="text-danger">`id`</span>),<br />
									<span class="text-primary">UNIQUE KEY</span> <span class="text-danger">`vehicles_id_unique`</span> (<span class="text-danger">`id`</span>),<br />
									<span class="text-primary">UNIQUE KEY</span> <span class="text-danger">`vehicles_vehicle_id_unique`</span> (<span class="text-danger">`vehicle_id`</span>),<br />
									<span class="text-primary">UNIQUE KEY</span> <span class="text-danger">`vehicles_vin_unique`</span> (<span class="text-danger">`vin`</span>),<br />
									<span class="text-primary">KEY <span class="text-danger">`vehicles_id_index`</span> (<span class="text-danger">`id`</span>),<br />
									<span class="text-primary">KEY <span class="text-danger">`vehicles_vehicle_id_index`</span> (<span class="text-danger">`vehicle_id`</span>)<br />
									) <span class="text-primary">ENGINE</span>=InnoDB <span class="text-primary">DEFAULT CHARSET</span>=utf8 <span class="text-primary">COLLATE</span>=utf8_unicode_ci;
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
