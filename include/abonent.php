<div class="cont_button">
    <?php
        $this->_account->getButtonAdd("addClient");
    ?>
</div>
<div class="bart_main">
    <table>
        <tbody id="bart_main">
        <tr>
            <th>#</th>
            <th>Код</th>
            <th>Номер телефона</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Баланс</th>
            <th>Тариф</th>
        </tr>
        <?php
        $this->getClient();
        ?>
        </tbody>
    </table>
</div>