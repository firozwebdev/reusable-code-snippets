<?php

$messages = array(
    'category_name.required' => 'Category Name should not be empty...',
    'category_name.min' => 'Category Name should be minimum 3 characters...',
    'category_description.required' => 'Category Description should not be empty...',
    'publication_status.required' => 'Choose Publication Status from select option...',

);

//This rule will validate data coming from form
$rules = array(
    'name' => 'required|min:3',
    'description' => 'required',
    'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
);
