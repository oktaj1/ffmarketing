<!-- resources/views/email_templates/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create New Email Template</h1>

    <form action="{{ route('email-templates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Template Name -->
        <div class="form-group">
            <label for="name">Template Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <!-- Email Body Text -->
        <div class="form-group">
            <label for="body">Email Body:</label>
            <textarea name="body" id="body" class="form-control" rows="10" required></textarea>
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Template</button>
    </form>
@endsection
