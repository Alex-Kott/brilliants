<?php

$dsn = 'mysql:dbname=brilliants;host=127.0.0.1';
$user = 'root';
$password = 'toor';

try {
    $conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

$page = $p *100;
$sql = "SELECT * FROM stones LIMIT $page, 100";


?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/bootstrap-slider.min.js"></script> <!-- ползунок -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.9.0/css/bootstrap-slider.min.css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" />
<script src="https://use.fontawesome.com/348244833d.js"></script>




<nav>
	<ul>
		<li><a href="#">Ювелирный дом</a></li>
		<li class="disk">•</li>
		<li><a href="#">Ваша примерка</a></li>
		<li class="disk">•</li>
		<li><a href="#">Базовая коллекция</a></li>
		<li class="disk">•</li>
		<li><a href="#">Свадебная коллекция</a></li>
		<li class="disk">•</li>
		<li><a href="#">Уникальное</a></li>
		<li></li>
		<li><span class="glyphicon glyphicon-shopping-cart"></span> </li>
		<li>Контакты</li>
	</ul>
</nav>


<div id="main">	
	<div class="row">
		<div class="col-4"></div>
		<div class="col-4">
			<div class="brand">
				<!-- <div>Hugo Freund &#38; Co</div> -->
				<img src="Hugo freund & Co.jpeg" />
			</div>
		</div>
		<div class="col-4">
			<div class="phone">
				<span><span class="glyphicon glyphicon-earphone"></span>+7 968 888 6881</span>
			</div>
		</div>
	</div>

	<form method="POST" action="/">
	<div class="row">
		<div class="col-2">
			<ul class="toggle">
				<li class="current">Русский</li>
				<li>English</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-12 cuts">
			<div class="cut current">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Round">Круглый</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Marquise">Маркиза</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Pear">Груша</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Oval">Овал</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Heart">Сердце</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Emerald">Изумруд</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Princess">Принцесса</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Radinat">Радиант</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Baguette">Багет</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Asher">Ашер</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/heart.jpg">
				</div>
				<span class="cut-name" data-cut="Cushion">Кушон</span>
			</div>
		</div>
	</div>
	<input type="hidden" name="cut" val="">

	<hr>

	<div class="row">
		<div class="col-4">
			<span class="measure">Цвет</span>
			<ul class="selector">
			    <li>1</li>
			    <li>2</li>
			    <li>3</li>
			    <li>4</li>
			    <li>5</li>
			</ul>
		</div>
		<div class="col-4">
			<span class="measure">Включения</span>
			<ul class="selector">
			    <li>1</li>
			    <li>2</li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="col-4 sym">
			<span class="measure">Симметрия</span>
			<ul class="selector">
			    <li data-value="Ideal">Идеальная</li>
			    <li data-value="Excellent">Отличная</li>
			    <input type="hidden" name="sym">
			</ul>
		</div>
		<div class="col-4 pol">
			<span class="measure">Полировка</span>
			<ul class="selector">
			    <li data-value="Ideal">Идеальная</li>
			    <li data-value="Excellent">Отличная</li>
			    <input type="hidden" name="pol">
			</ul>
		</div>
		<div class="col-4 mk">
			<span class="measure">Огранка</span>
			<ul class="selector">
			    <li data-value="Ideal">Идеальная</li>
			    <li data-value="Excellent">Отличная</li>
			    <input type="hidden" name="mk">
			</ul>

		</div>

	</div>

	<hr>

	<div class="row">
		<div class="col-6 wps"> <!-- wps - weight, price, size -->
			<div class="stone-size">
				<hr class="extension-line">
				<img src="circle-brilliant.jpeg">
				<input type="text" value="3" max="99" > <span>мм</span>
				<hr class="extension-line">
			</div>
			<div class="stone-weight">
				<span>Вес (ct)</span>
				<div class="range">
					<input type="text" name="left-value" value="0.5" >
					<input class="input-range" id="weight-range" data-slider-min="0.5" data-slider-max="13" data-slider-step="0.01" data-slider-value="[0.5,13]">
					<input type="text" name="right-value" value="13" >
				</div>

			</div>
		</div>
		<div class="col-6 wps">
			<div class="stone-price">
				<span>Цена (руб)</span>
				<div class="range">
					<input type="text" name="left-value" value="0.5" >
					<input class="input-range" id="price-range" data-slider-min="0.5" data-slider-max="13" data-slider-step="0.1" data-slider-value="[0.5,13]">
					<input type="text" name="right-value" value="13" >
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-5"></div>
		<div class="col-2">
			<div class="search-btn">
				<div class="left-top-corner"></div>
				<div class="right-top-corner"></div>
				<div class="left-bottom-corner"></div>
				<div class="right-bottom-corner"></div>
				<span class="glyphicon glyphicon-search"></span><span> Поиск</span>
			</div>
		</div>
		<div class="col-5"></div>
	</div>
	</form>

	<table>
		<thead>
			<tr>
				<td></td>
				<td>Форма</td>
				<td>Цена (руб)</td>
				<td>Вес (ct)</td>
				<td>Цвет по ТУ</td>
				<td>Чистота</td>
				<td>Огранка</td>
				<td>Симметрия</td>
				<td>Полировка</td>
				<td>Цена за ct (руб.)</td>
				<td>Дата доставки</td>
			</tr>
		</thead>
		<tbody>	
			<?php
			foreach($conn->query($sql) as $row):
			?>
			<tr>

				<td>
					<input type="checkbox" class="form-check-input">
				</td>
				<td>
					<?= $row['cut'] ?>
				</td>
				<td>
					<!-- цена непонятно где -->
				</td>
				<td>
					<?= $row['ct'] ?>
				</td>
				<td>
					<?= $row['col'] ?>
				</td>
				<td>
					<?= $row['cl'] ?>
				</td>
				<td>
					<?= $row['mk'] ?>
				</td>
				<td>
					<?= $row['sym'] ?>
				</td>
				<td>
					<?= $row['pol'] ?>
				</td>
				<td>
					<!-- price per carat -->
				</td>
				<td>
					<!-- delivery date -->
				</td>

			</tr>
			<?php
			endforeach;
			?>



		</tbody>

	</table>

	<hr>
	<div class="footer row">
		<div class="col-3">
			<ul>
				<li>Связаться с нами</li>
				<li>Контакты</li>
				<li>Команда</li>
				<li>Возврат</li>
				<li>Конфиденциальность</li>
			</ul>
		</div>
		<div class="col-3">
			<ul>
				<li><i class="fa fa-fw fa-facebook"></i>    Facebook</li>
				<li><i class="fa fa-fw fa-instagram"></i>    Instagram</li>
				<li><i class="fa fa-fw fa-youtube"></i>    YouTube</li>
			</ul>
		</div>
		<div class="col-3"></div>
		<div class="col-3 partners">
			<p>&#9400; 1908, Hugo Freund &amp; Co.</p>
			<p class="labels">
				<i class="fa fa-cc-discover" aria-hidden="true"></i>
				<i class="fa fa-cc-jcb" aria-hidden="true"></i>
			</p>
			<p class="labels">
				<i class="fa fa-cc-mastercard" aria-hidden="true"></i>
				<i class="fa fa-cc-visa" aria-hidden="true"></i>
			</p>
		</div>
	</div>



</div>



<script src="script.js"></script>