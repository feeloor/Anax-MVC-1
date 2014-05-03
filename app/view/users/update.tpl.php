<?php if(is_object($user)): ?>
<form method="post">
<input type="hidden" name="redirect" value="<?=$this->url->create('')?>">
<input type="hidden" name="id" value="<?=$user->id?>">
<p>Acronym:<br><input type="text" name="acronym" value="<?=$user->acronym?>"></p>
<p>Name:<br> <input type="text" name="name" value="<?=$user->name?>"></p>
<p>Email:<br> <input type="text" name="email" value="<?=$user->email?>"></p>
<p><input type="submit" name="doSubmit" value="Spara" onClick="this.form.action = '<?=$this->url->create('users/save')?>'"></p>

<?php else : ?>
<p>No user with that id was found</p>
<?php endif; ?>