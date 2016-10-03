<?php
/**
 * Created by PhpStorm.
 * User: danielphp
 * Date: 12/08/16
 * Time: 14:13
 */

namespace builder;


class builder
{
    public function outputOptions($array)
    {
        foreach ($array as $key => $val) {
            ?>

            <option value="<?php echo $key ?>"><?php echo $val ?></option>
            <?php

        }
    }

    public function outputMonetar($array, $extraClass)
    {
        foreach ($array as $key => $val) {
            ?>

            <div class="form-group input-group">
                <span class="input-group-addon"><?php echo $val ?></span>
                <input type="text" value="0" name="<?php echo $key ?>"
                       class="form-control input-lg input-group-lg <?php echo $extraClass . ' ' . $key ?>">

            </div>
            <?php

        }
    }

    public function outputPlataBon($array, $extraClass = "")
    {
        foreach ($array as $key => $val) {
            ?>

            <div class="form-group input-group">

                <input type="text" value="0" name="<?php echo $key ?>"
                       class="form-control input-lg input-group-lg <?php echo $extraClass . ' ' . $key ?>">

            </div>
            <?php

        }
    }

    public function outputClientiHeader($array, $extraClass = "", $blockedArray = array(),$submitButtonClass=" btn-danger ",$submitButtonValue="Adaug",$hideHidden=false)
    {
        ?>

        <thead>
        <tr>
            <?
            foreach ($array as $key => $val) {
              if(is_object($val)){
                  $title=$val->name;

              }
              else{
                  $title=$val;
              }

                ?>

                <th><? echo $title ?></th>


                <?
            }
            ?>
            <th>Actiune</th>

            <?
            reset($array);
            ?>
        </tr>
        </thead>
    <tbody class="<?= $extraClass ?>">
        <tr>

            <?
            foreach ($array as $key => $val) {
                ?>

                <td>
                    <?$this->buildFields($key,$blockedArray,$val,$extraClass,$hideHidden)?>

                </td>
                <?php

            }
            ?>
            <td><input type="button" class="btn <?=$submitButtonClass?>" id="adaug" value="<?=$submitButtonValue?>"></td>
        <tr>
        <?
        echo '</tr>';
    }

    public function buildFields($key,$blockedArray,$val,$extraClass,$hideHidden=false)
    {
        if (!in_array($key, $blockedArray) ) {
            if (is_object($val)) {
                $params = (array)$val->params;

                switch ((string)$val->field_type) {
                    case 'dropdown': ?>
                        <select name="<?php echo $key ?>"<? if (in_array($key, $blockedArray)) echo ' disabled ' ?>
                                class="form-con input-lg input-group-lg <?php echo $extraClass . ' ' . $key ?>">
                            <? foreach ($params as $param_key => $param_val): ?>
                                <option value="<?= $param_val ?>"><?= $param_val ?></option>
                            <?endforeach; ?>
                        </select>


                        <? break;

                }


            } else {
                ?>
                <input type="text"
                       name="<?php echo $key ?>" <? if (in_array($key, $blockedArray)) echo ' disabled ' ?>
                       class="form-control input-xs input-group-xs <?php echo $extraClass . ' ' . $key ?>">
                <?
            }
        }
    }
}