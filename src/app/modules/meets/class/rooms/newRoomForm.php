<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-02-14, 06:06:05
 * 
 * Opis zmian:
 * 2014-02-14:
 * -Utworzenie pliku
 */

namespace meets\rooms;

use yiff\form;
/**
 * @property form\element\text $name Nazwa pokoju
 * @property form\element\text $size
 * @property form\element\text $room_nr
 * @property form\element\text $group_name
 * @property form\element\submit $button
 * 
 */
class newRoomForm extends form\form
{

    public function init()
    {
        $this->addElement('text', 'name', [
            'label' => 'Nazwa pokoju',
        ]);

        $this->addElement('text', 'size', [
            'label' => 'Ilość osób'
        ]);

        $this->addElement('text', 'room_nr', [
            'label' => 'Numer pokoju'
        ]);

//        $this->addElement('text', 'group_name', [
//            'label' => 'Nazwa grupy'
//        ]);

        $this->addElement('submit', 'button', [
            'ignore' => true,
            'label' => 'Zapisz',
        ]);
    }

}
