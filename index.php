<?php
$dsn = 'mysql:dbname=brilliants;host=127.0.0.1';
$user = 'root';
$password = 'toor';

function rubusd(){
	$url = "http://www.cbr.ru/scripts/XML_daily.asp";
	$params = array();

    try{
        $response = file_get_contents($url, false);
    } catch (Exception $e) {
    	// var_dump($e);
    }
    $xml_response = new SimpleXMLElement($response);
    foreach($xml_response->Valute as $currency){
    	if($currency->NumCode == 840){
    		$rate = $currency->Value;
    	}
    }
    $rate = str_replace(',', '.', $rate);
    return floatval($rate);
}

$rate = rubusd();


try {
    $conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}


$cut = 'Round';
if($_POST['cut']){
	$cuts = implode("', '", explode(',', $_POST['cut']));
	$cut = "IN ('$cuts')";
} else {
	$cut = 'IS NOT NULL';
}




$sym = "'Ideal', 'Excellent'";
if($_POST['sym']){
	$sym = "'".implode("','", explode(',', $_POST['sym']))."'";
}

$pol = "'Ideal', 'Excellent'";
if($_POST['pol']){
	$pol = "'".implode("','", explode(',', $_POST['pol']))."'";
}

$mk = "'Ideal', 'Excellent'";
if($_POST['mk']){
	$mk = "'".implode("','", explode(',', $_POST['mk']))."'";
}

$lw = $_POST['left-weight'] ? $_POST['left-weight'] : '0.08';
$rw = $_POST['right-weight'] ? $_POST['right-weight'] : '13';

$page = $_GET['page'] ? $_GET['page'] : 1;
$p = ($page - 1) * 100;

$sql = "
	SELECT * FROM stones 
	WHERE `cut` $cut AND 
		`sym` IN ($sym) AND
		`pol` IN ($pol) AND
		`mk` IN ($mk) AND 
		(`ct` BETWEEN $lw AND $rw) AND
		`cl` IN ('IF', 'FL') AND 
		`lab` IN ('GIA')
	ORDER BY `ct` ASC, `cl` ASC
		LIMIT $p, 100
		";

// var_dump($_POST);
// var_dump($sql);

$sql_count = "
	SELECT COUNT(`id`) AS `qty` FROM stones 
	WHERE `cut` = '$cut' AND 
	`sym` IN ($sym) AND
	`pol` IN ($pol) AND
	`mk` IN ($mk) AND 
	(`ct` BETWEEN $lw AND $rw) AND
	`cl` IN ('IF', 'FL')
";

foreach ($conn->query($sql_count) as $key => $value) {
	$count = $value['qty'];
}

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
		<li><a href="#" data-lang-ru="Ювелирный дом" data-lang-en="Jewelry house">Ювелирный дом</a></li>
		<li class="disk">•</li>
		<li><a href="#" data-lang-ru="Ваша примерка" data-lang-en="Your fitting">Ваша примерка</a></li>
		<li class="disk">•</li>
		<li><a href="#" data-lang-ru="Базовая коллекция" data-lang-en="Base collection">Базовая коллекция</a></li>
		<li class="disk">•</li>
		<li><a href="#" data-lang-ru="Свадебная коллекция" data-lang-en="Wedding collection">Свадебная коллекция</a></li>
		<li class="disk">•</li>
		<li><a href="#" data-lang-ru="Уникальное" data-lang-en="Unique">Уникальное</a></li>
		<li></li>
		<li><span class="glyphicon glyphicon-shopping-cart"></span> </li>
		<li><span data-lang-ru="Контакты" data-lang-en="Contacts">Контакты</span></li>
	</ul>
</nav>


<div id="main">	
	<div class="row">
		<div class="col-4"></div>
		<div class="col-4">
			<div class="brand">
				<!-- <div>Hugo Freund &#38; Co</div> -->
				<!-- <img src="Hugo freund & Co.jpeg" /> -->
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
			<ul class="toggle" id="lang">
				<li class="current" data-lang="ru">Русский</li>
				<li data-lang="en">English</li>
			</ul>
			<input type="hidden" name="lang" value="<?= $_POST['lang'] ?>">
		</div>
	</div>

	<div class="row">
		<div class="col-12 cuts">
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Round.png">
				</div>
				<span class="cut-name" data-cut="Round" data-lang-ru="Круглый" data-lang-en="Round">Круглый</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Marquise.png">
				</div>
				<span class="cut-name" data-cut="Marquise" data-lang-ru="Маркиза" data-lang-en="Marquise">Маркиза</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Pear.png">
				</div>
				<span class="cut-name" data-cut="Pear" data-lang-ru="Груша" data-lang-en="Pear">Груша</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Oval.png">
				</div>
				<span class="cut-name" data-cut="Oval" data-lang-ru="Овал" data-lang-en="Oval">Овал</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Heart.png">
				</div>
				<span class="cut-name" data-cut="Heart" data-lang-ru="Сердце" data-lang-en="Heart">Сердце</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Emerald.png">
				</div>
				<span class="cut-name" data-cut="Emerald" data-lang-ru="Изумруд" data-lang-en="Emerald">Изумруд</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Princess.png">
				</div>
				<span class="cut-name" data-cut="Princess" data-lang-ru="Принцесса" data-lang-en="Princess">Принцесса</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Radiant.png">
				</div>
				<span class="cut-name" data-cut="Radiant" data-lang-ru="Радиант" data-lang-en="Radiant">Радиант</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Baguette.png">
				</div>
				<span class="cut-name" data-cut="Baguette" data-lang-ru="Багет" data-lang-en="Baguette">Багет</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Asscher.png" >
				</div>
				<span class="cut-name" data-cut="Asscher" data-lang-ru="Ашер" data-lang-en="Asscher">Ашер</span>
			</div>
			<div class="cut">
				<div class="cut-img">
					<img src="brilliants/Cushion.png">
				</div>
				<span class="cut-name" data-cut="Cushion" data-lang-ru="Кушон" data-lang-en="Cushion">Кушон</span>
			</div>
		</div>
	</div>
	<input type="hidden" name="cut" value="<?= $_POST['cut'] ?>">

	<hr>

	<div class="row">
		<div class="col-12">
			<span class="measure" data-lang-ru="Цвет" data-lang-en="Color">Цвет</span>
			<ul class="selector color">
			    <li data-lang-ru="1" data-lang-en="D">1</li>
			    <li data-lang-ru="2" data-lang-en="E">2</li>
			    <li data-lang-ru="3" data-lang-en="F">3</li>
			    <li data-lang-ru="4" data-lang-en="G">4</li>
			    <li data-lang-ru="5" data-lang-en="H">5</li>
			    <li data-lang-ru="6" data-lang-en="I">6</li>
			    <li data-lang-ru="7" data-lang-en="J">7</li>
			    <li data-lang-ru="8" data-lang-en="K">8</li>
			    <li data-lang-ru="9" data-lang-en="L">9</li>
			    <li data-lang-ru="10" data-lang-en="M">10</li>
			    <li data-lang-ru="11" data-lang-en="N">11</li>
			    <li data-lang-ru="12" data-lang-en="O">12</li>
			    <li data-lang-ru="13" data-lang-en="P">13</li>
			    <li data-lang-ru="14" data-lang-en="Q">14</li>
			    <li data-lang-ru="15" data-lang-en="R">15</li>
			    <li data-lang-ru="16" data-lang-en="S">16</li>
			    <li data-lang-ru="17" data-lang-en="T">17</li>
			    <li data-lang-ru="18" data-lang-en="U">18</li>
			    <li data-lang-ru="19" data-lang-en="V">19</li>
			    <li data-lang-ru="20" data-lang-en="W">20</li>
			    <li data-lang-ru="21" data-lang-en="X">21</li>
			    <li data-lang-ru="22" data-lang-en="Y">22</li>
			    <li data-lang-ru="23" data-lang-en="Z">23</li>
			</ul>
			<input type="hidden" name="color" value="">
		</div>
		
	</div>

	<div class="row">
		<div class="col-6">
			<span class="measure" data-lang-ru="Включения" data-lang-en="Inclusion">Включения</span>
			<ul class="selector clarity">
			    <li data-lang-ru="1" data-lang-en="FL">1</li>
			    <li data-lang-ru="2" data-lang-en="IF">2</li>
			    <li class="disable" data-lang-ru="3" data-lang-en="VVS1">3</li>
			    <li class="disable" data-lang-ru="4" data-lang-en="VVS2">4</li>
			    <li class="disable" data-lang-ru="5" data-lang-en="VS1">5</li>
			    <li class="disable" data-lang-ru="6" data-lang-en="VS2">6</li>
			    <li class="disable" data-lang-ru="7" data-lang-en="SI1">7</li>
			</ul>
			<input type="hidden" name="clear" value="">
		</div>
	</div>

	<div class="row">
		<div class="col-8 sym spm"> <!-- spm = sym, pol, mk -->
			<span class="measure" data-lang-ru="Симметрия" data-lang-en="Symmetry">Симметрия</span>
			<ul class="selector">
			    <li data-value="Ideal" data-lang-ru="Идеальная" data-lang-en="Ideal">Идеальная</li>
			    <li data-value="Excellent" data-lang-ru="Отличная" data-lang-en="Excellent">Отличная</li>
			    <li class="disable" data-value="Very good" data-lang-ru="Очень хорошая" data-lang-en="Very good">Очень хорошая</li>
			    <li class="disable" data-value="Good" data-lang-ru="Хорошая" data-lang-en="Good">Хорошая</li>
			    <li class="disable" data-value="Fair" data-lang-ru="Неплохая" data-lang-en="Fair">Неплохая</li>
			    <li class="disable" data-value="Poor" data-lang-ru="Плохая" data-lang-en="Poor">Плохая</li>
			    <input type="hidden" name="sym" value="<?= $_POST['sym'] ?>">
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-8 pol spm">
			<span class="measure" data-lang-ru="Полировка" data-lang-en="Polishing">Полировка</span>
			<ul class="selector">
			    <li data-value="Ideal" data-lang-ru="Идеальная" data-lang-en="Ideal">Идеальная</li>
			    <li data-value="Excellent"  data-lang-ru="Отличная" data-lang-en="Excellent">Отличная</li>
			    <li class="disable" data-value="Very good" data-lang-ru="Очень хорошая" data-lang-en="Very good">Очень хорошая</li>
			    <li class="disable" data-value="Good" data-lang-ru="Хорошая" data-lang-en="Good">Хорошая</li>
			    <li class="disable" data-value="Fair" data-lang-ru="Неплохая" data-lang-en="Fair">Неплохая</li>
			    <li class="disable" data-value="Poor" data-lang-ru="Плохая" data-lang-en="Poor">Плохая</li>
			    <input type="hidden" name="pol" value="<?= $_POST['pol'] ?>">
			</ul>
		</div>
		

	</div>
	<div class="row">
		<div class="col-8 mk spm">
			<span class="measure" data-lang-ru="Огранка" data-lang-en="Cut Grade">Огранка</span>
			<ul class="selector">
			    <li data-value="Ideal" data-lang-ru="Идеальная" data-lang-en="Ideal">Идеальная</li>
			    <li data-value="Excellent"  data-lang-ru="Отличная" data-lang-en="Excellent">Отличная</li>
			    <li class="disable" data-value="Very good" data-lang-ru="Очень хорошая" data-lang-en="Very good">Очень хорошая</li>
			    <li class="disable" data-value="Good" data-lang-ru="Хорошая" data-lang-en="Good">Хорошая</li>
			    <li class="disable" data-value="Fair" data-lang-ru="Неплохая" data-lang-en="Fair">Неплохая</li>
			    <li class="disable" data-value="Poor" data-lang-ru="Плохая" data-lang-en="Poor">Плохая</li>
			    <input type="hidden" name="mk" value="<?= $_POST['mk'] ?>">
			</ul>
		</div>

	</div>

	<hr>

	<div class="row">
		<div class="col-6 wps"> <!-- wps - weight, price, size -->
			<div class="stone-size">
				<hr class="extension-line">
				<img src="circle-brilliant.jpeg">
				<input type="text" value="3" max="99" > <span data-lang-ru="мм" data-lang-en="mm">мм</span>
				<hr class="extension-line">
			</div>
			<div class="stone-weight">
				<span   data-lang-ru="Вес (ct)" data-lang-en="Weight (ct)">Вес (ct)</span>
				<div class="range">
					<input type="text" name="left-weight" class="left-value" value="<?= $lw ? $lw : '0.08' ?>" >
					<input class="input-range" id="weight-range" data-slider-min="0.08" data-slider-max="13" data-slider-step="0.01" data-slider-value="[0.08,13]">
					<input type="text" name="right-weight" class="right-value" value="<?= $rw ? $rw : '13' ?>" >
				</div>

			</div>
		</div>
		<div class="col-6 wps">
			<div class="stone-price">
				<span  data-lang-ru="Цена (RUR)" data-lang-en="Price (USD)">Цена (руб)</span>
				<div class="range">
					<input type="text" name="left-value" class="left-value" value="0.5" >
					<input class="input-range" id="price-range" data-slider-min="0.5" data-slider-max="13" data-slider-step="0.1" data-slider-value="[0.5,13]">
					<input type="text" name="right-value" class="right-value" value="13" >
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
				<span class="glyphicon glyphicon-search"></span><span  data-lang-ru="Поиск" data-lang-en="Search"> Поиск</span>
			</div>
		</div>
		<div class="col-5"></div>
	</div>
	</form>

	<table>
		<thead>
			<tr>
				<td class="unbordered"></td>
				<td  data-lang-ru="Форма" data-lang-en="Cut">Форма</td>
				<td  data-lang-ru="Цена (RUR)" data-lang-en="Price (USD)">Цена (руб)</td>
				<td  data-lang-ru="Цена за ct (RUR)" data-lang-en="Price per ct (USD)">Цена за ct (руб.)</td>
				<td  data-lang-ru="Вес (ct)" data-lang-en="Weight (ct)">Вес (ct)</td>
				<td  data-lang-ru="Цвет по ТУ" data-lang-en="Color">Цвет по ТУ</td>
				<td  data-lang-ru="Чистота" data-lang-en="Clarity">Чистота</td>
				<td  data-lang-ru="Огранка" data-lang-en="Cut Grade">Огранка</td>
				<td  data-lang-ru="Симметрия" data-lang-en="Symmetry">Симметрия</td>
				<td  data-lang-ru="Полировка" data-lang-en="Polishing">Полировка</td>
				<td  data-lang-ru="Купить" data-lang-en="Buy">Купить</td>
			</tr>
		</thead>
		<tbody>	
			<?php
			foreach($conn->query($sql) as $row):
			?>
			<tr data-id="<?= $row['id'] ?>">

				<td class="unbordered">
					<input type="checkbox" class="form-check-input">
				</td>
				<td>
					<p><?= $row['cut'] ?></p>
					<img class="cut-mini" src="/brilliants/<?= $row['cut'] ?>.png">
				</td>
				<td>
					<span data-lang-ru="<?= number_format($row['tp']*$rate, 2, ',', ' ') ?>" data-lang-en="<?= number_format($row['tp'], 2, ',', ' ') ?>"><?= number_format($row['tp']*$rate, 2, ',', ' ') ?></span>
				</td>
				<td>
					<span data-lang-ru="<?= number_format($row['ap']*$rate, 2, ',', ' ') ?>" data-lang-en="<?= number_format($row['ap'], 2, ',', ' ') ?>"><?= number_format($row['ap']*$rate, 2, ',', ' ') ?></span>
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
					<div class="price-label add-cart" style="width: 90%;">
						<div class="top"><span class="glyphicon glyphicon-shopping-cart"></span>
							<span data-lang-ru="Купить" data-lang-en="Buy"  style="color: #cecece;">Купить</span></div>
					</div>
				</td>
			</tr>

			<tr class="details" data-details="<?= $row['id']?>">
				<td class="unbordered"></td>
				<td colspan="10">
					<div class="more">
						<div class="blueprint">
							<img src="blueprint.jpg">
						</div>
						<div class="parameters">
							<table class="det">
								<tr>
									<td data-lang-ru="Форма" data-lang-en="Cut">Форма</td>
									<td class="brval"><?= $row['cut'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Вес" data-lang-en="Weight">Вес</td>
									<td class="brval"><?= $row['ct'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Цвет" data-lang-en="Color">Цвет</td>
									<td class="brval"><?= $row['col'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Чистота" data-lang-en="Clarity">Чистота</td>
									<td class="brval"><?= $row['cl'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Размер" data-lang-en="Size">Размер</td>
									<td class="brval"><?= $row['mes'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Глубина" data-lang-en="Deep">Глубина</td>
									<td class="brval"><?= $row['dp'] ?>%</td>
								</tr>
								<tr>
									<td data-lang-ru="Площадка" data-lang-en="Square">Площадка</td>
									<td class="brval"></td>
								</tr>
								<tr>
									<td data-lang-ru="Огранка" data-lang-en="Cut Grade">Огранка</td>
									<td class="brval"><?= $row['mk'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Полировка" data-lang-en="Polishing">Полировка</td>
									<td class="brval"><?= $row['pol'] ?></td>
								</tr>
								<tr>
									<td data-lang-ru="Симметрия" data-lang-en="Symmetry">Симметрия</td>
									<td class="brval"><?= $row['sym'] ?></td>
								</tr>
								<tr>
									<td><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <a target="_blank" href="<?= $row['cp'] ?>">GIA</a></td>
									<td><i class="fa fa-camera" aria-hidden="true"></i> <a href="#"  data-lang-ru="Фото" data-lang-en="Photo">Photo</a></td>
								</tr>
							</table>
						</div>
						<div class="rectangles">
							<div class="price-label">
								<div class="top">
									<span style="color: #000;" data-lang-ru="<?= number_format($row['ap']*$rate, 2, ',', ' ') ?> &#8381;" data-lang-en="<?= number_format($row['ap'], 2, ',', ' ') ?> $">
										<?=number_format($row['ap']*$rate, 2, ',', ' ') ?> &#8381;
									</span>
								</div>
								<div class="bottom"><span  data-lang-ru="Цена за ct" data-lang-en="Price per ct">Цена за ct</span></div>
							</div>
							<div class="price-label">
								<div class="top">
									<span style="color: #000;" data-lang-ru="<?= number_format($row['tp']*$rate, 2, ',', ' ') ?> &#8381;" data-lang-en="<?= number_format($row['tp'], 2, ',', ' ') ?> $">
										<?=number_format($row['tp']*$rate, 2, ',', ' ') ?> &#8381;
									</span>
								</div>
								<div class="bottom"><span data-lang-ru="Цена за камень" data-lang-en="Total price">Цена за камень</span></div>
							</div>
							<div class="price-label">
								<div class="top"><span style="color: #000;">10%</span></div>
								<div class="bottom"><span data-lang-ru="Скидка" data-lang-en="HCA Score">Скидка</span></div>
							</div>
							<div class="price-label">
								<div class="top"><span style="color: #000;">180 000 ₽</span></div>
								<div class="bottom"><span data-lang-ru="Итоговая цена (с НДС)" data-lang-en="Total (with VAT)">Итоговая цена (с НДС)</span></div>
							</div>
							<div class="price-label callback">
								<div class="top" style="color: #000;"><span class="glyphicon glyphicon-earphone"></span><span  data-lang-ru="Заказать консультацию" data-lang-en="Callback">Заказать консультацию</span></div>
							</div>
							<div class="price-label add-cart">
								<div class="top"><span class="glyphicon glyphicon-shopping-cart"></span>
									<span data-lang-ru="Купить" data-lang-en="Buy"  style="color: #cecece;">Купить</span></div>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<?php
			endforeach;
			?>

		</tbody>

	</table>

	<?php
	$start = 1;
	$end = 10;
	if(($page - 5) >= 1){
		$start = $page - 5;
	}

	if(($page + 5) <= ($count/100)){
		$end = $page + 5;
	} else {
		$end = intval(ceil($count / 100));
	}


	?>

	<div class="pagination-nav">
		<ul class="pagination">
			<li class="page-item"><a class="page-link" href="/?page=1">Начало</a></li>
			<?php
			foreach(range($start, $end) as $i):
			?>
				<li class="page-item"><a class="page-link" href="/?page=<?= $i ?>"><?= $i ?></a></li>
			<?php
			endforeach;
			?>

			<li class="page-item"><a class="page-link" href="/?page=<?= intval(ceil($count / 100))?>">Конец</a></li>
		</ul>
	</div>

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

<script>
	(function(w, d, s, l, i) {
	    w[l] = w[l] || [];
	    w[l].push({
	        'gtm.start': new Date().getTime(),
	        event: 'gtm.js'
	    });
	    var f = d.getElementsByTagName(s)[0],
	        j = d.createElement(s),
	        dl = l != 'dataLayer' ? '&l=' + l : '';
	    j.async = true;
	    j.src =
	        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
	    f.parentNode.insertBefore(j, f);
	})(window, document, 'script', 'dataLayer', 'GTM-W44K5C9');
</script>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W44K5C9"
   height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script type="text/javascript" > 
(function(d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter46608843 = new Ya.Metrika({
                id: 46608843,
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true,
                trackHash: true,
                ecommerce: "dataLayer"
            });
        } catch (e) {}
    });
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function() {
            n.parentNode.insertBefore(s, n);
        };
    s.type = "text/javascript";
    s.async = true;
    s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/watch.js";
    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else {
        f();
    }
})(document, window, "yandex_metrika_callbacks");
</script> 
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109522789-1"></script>
<script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
   gtag('js', new Date());
   
   gtag('config', 'UA-109522789-1');
</script>