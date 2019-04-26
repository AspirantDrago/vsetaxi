<?php
include 'blocks/header.php';
?>
    <article>
        <div class="content">
            <div class="row opacity_map_over">                 <!-- Тут творится полный бред, я сам, честно не разбираюсь, что тут написал. -->
                <div class="col-12 opacity_map_over">
                    <h3 class="centred_big_text">
                        Расcчитайте вашу поездку максимально выгодно!
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 opacity_map_over">
                    <div class="row">
                        <button type="button" class="autorizate"><a href="#">Авторизация</a></button>
                    </div>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="d-flex col-sm-4 justify-content-center">
                                <a onclick="swap_marshrut()">
                                    <h4><i class="fa fa-chevron-up"></i> Куда едем?</h4>
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.4s">
                                    <label class="sr-only">Улица</label>
                                    <input type="text" name="finish_street" id="finish_street" class="form-control" placeholder="Улица" value="<?php echo $_SESSION['street2']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.6s">
                                    <label class="sr-only">Дом</label>
                                    <input type="text" name="finish_home" id="finish_home" class="form-control" placeholder="Дом" value="<?php echo $_SESSION['home2']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.6s">
                                    <label class="sr-only">Подъезд</label>
                                    <input type="text" name="finish_entrance" id="finish_entrance" class="form-control" placeholder="Подъезд" value="<?php echo $_SESSION['entrance2']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex col-sm-4 justify-content-center">
                                <a onclick="swap_marshrut()">
                                    <h4><i class="fa fa-chevron-down"></i> Откуда едем?</h4>
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.4s">
                                    <label class="sr-only">Улица</label>
                                    <input type="text" name="start_street" id="start_street" class="form-control" placeholder="Улица" value="<?php echo $_SESSION['street1']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.6s">
                                    <label class="sr-only">Дом</label>
                                    <input type="text" name="start_home" id="start_home" class="form-control" placeholder="Дом" value="<?php echo $_SESSION['home1']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-2">
                                <div class="form-group wow fadeInUp" data-wow-delay="0.6s">
                                    <label class="sr-only">Подъезд</label>
                                    <input type="text" name="start_entrance" id="start_entrance" class="form-control" placeholder="Подъезд" value="<?php echo $_SESSION['entrance1']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class='services'>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-row align-items-center">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Доп. услуги</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected>Выбрать...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-row align-items-center">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Тариф</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected>Выбрать...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-row align-items-center">
                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Маршрут</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                            <option selected>Выбрать...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" class="zakaz" value="Посмотреть цены!"></input>
                        </div>
                    </form>
                    <div style="display: none;">
                        <?php
                        require_once 'servises/calc.php';
                        ?>
                    </div>
                    <div class="row list_counts">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Компания</th>
                                <th>Цена</th>
                                <th>Заказать</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($costs as $cost) {
                                ?>
                                <tr>
                                    <th scope="row"><img src="<?php echo $cost['image']?>" alt="<?php echo $cost['name']?>" class="img-fluid logo_taxi">
                                    </th>
                                    <td><?php echo $cost['name']?></td>
                                    <td><?php echo $cost['cost']?></td>
                                    <td>
                                        <button type="button" class="zakaz"><a href="<?php echo $cost['link']?>">Заказать</a>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="back_map"></div>
                </div>
            </div>
    </article>
<?php
include 'blocks/footer.php';
?>