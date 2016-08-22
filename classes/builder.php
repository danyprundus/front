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

    public function outputClientiHeader($array, $extraClass = "", $blockedArray = array())
    {
        ?>

        <thead>
        <tr>
            <?
            foreach ($array as $key => $val) {
                ?>

                <th><? echo $val ?></th>


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
        <tr id="clientiStart">

            <?
            foreach ($array as $key => $val) {
                ?>

                <td><input type="text"
                           name="<?php echo $key ?>" <? if (in_array($key, $blockedArray)) echo ' disabled ' ?>
                           class="form-control input-lg input-group-lg <?php echo $extraClass . ' ' . $key ?>"></td>
                <?php

            }
            ?>
            <td><input type="button" class="btn btn-danger " id="adaug" value="Adaug"></td>
        <tr>
        <?
        echo '</tr>';
    }
}