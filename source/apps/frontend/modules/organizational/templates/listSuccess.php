<?php
// auto-generated by sfPropelCrud
// date: 2009/07/17 06:54:07
?>
<h1>organizational</h1>

<table>
<thead>
<tr>
  <th>Id</th>
  <th>Name</th>
</tr>
</thead>
<tbody>
<?php foreach ($organizationals as $organizational): ?>
<tr>
    <td><?php echo link_to($organizational->getId(), 'organizational/show?id='.$organizational->getId()) ?></td>
      <td><?php echo $organizational->getName() ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo link_to ('create', 'organizational/create') ?>