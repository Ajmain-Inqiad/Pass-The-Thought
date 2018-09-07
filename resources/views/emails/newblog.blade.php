<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        Hi <h2>{{ $user->name }}</h2>,
        <hr>
        <p>A new blog has been created at larablog titled "{{ $blog->title }}"</p>
    </body>
</html>
