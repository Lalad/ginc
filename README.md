Ginc for Ginc Is Not a CMS
==========================

Ginc is lighwhite and fast PHP HMVC developmment framework, that whas developed in 2011 as part of experiment to get the most faster execution and keep a relative simplicity of use.

API
===

Base
----


Load module `$this->module('module_name', 'action', array('key1' => 'var1', ...))`

Load model `$this->model('action', array('key1' => 'var1', ...), 'model_name')`

Load view `$this->view('view_name', array('key1' => 'var1', ...))`


Components
----------

Load component `Components::load('Components_name', 'action', array('key1' => 'var1', ...))`

Check if exists and active `Components::checkActive('Components_name')`

Modules
-------

Load module `Modules::load('Modules_name', 'action', array('key1' => 'var1', ...))`

Check if exists and active `Modules::checkActive('Components_name')`


Language
--------

Load language `$Lang = Lang::_get('fileName1', 'file2', 'file3' .....)`

Check if language file exists `Lang::exists('file_name')`

Clear memory `Lang::_remove('Article')`

License
=======

>    Ginc is free software: you can redistribute it and/or modify
>    it under the terms of the GNU General Public License as published by
>    (at your option) any later version.
>
>    Ginc is distributed in the hope that it will be useful,
>    but WITHOUT ANY WARRANTY; without even the implied warranty of
>    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
>    GNU General Public License for more details.
>    You should have received a copy of the GNU General Public License
>    along with Ginc.  If not, see <http://www.gnu.org/licenses/>.

Notice:

Some parts of the code belong to other frameworks and are licensed under their own licenses.

Authors
=======

Ghazi ABDELHAK (project initiator),

Hicham ABDELKAOUI.
