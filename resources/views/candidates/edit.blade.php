@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Candidate</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('candidates.update', $candidate) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $candidate->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $candidate->email }}" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $candidate->phone }}" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ $candidate->dob }}" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" required>{{ $candidate->address }}</textarea>
                </div>
                <div class="form-group">
                    <label>Resume (PDF/Doc)</label>
                    <input type="file" name="resume" class="form-control-file">
                    @if ($candidate->resume)
                    <p>Current Resume: <a href="{{ Storage::url('public/' . $candidate->resume) }}" target="_blank">{{ basename($candidate->resume) }}</a></p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Candidate</button>
            </form>
        </div>
    </div>
</div>
@endsection