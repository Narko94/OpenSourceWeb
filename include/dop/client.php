<tr onclick="view('result');loadPage('?do=win&option=info&id=<?php print $row['id']; ?>', 'result', 'Данные клиента #<?php print $row['id']."->".$row['telephone']; ?>');">
    <th><?php print $row['id']; ?></th>
    <th><?php print $row['code']; ?></th>
    <th><?php print $row['telephone']; ?></th>
    <th><?php print $row['fn']; ?></th>
    <th><?php print $row['ln']; ?></th>
    <th><?php print $row['on']; ?></th>
    <th><?php print $row['balanse']; ?></th>
    <th><?php print $row['tname']; ?></th>
</tr>