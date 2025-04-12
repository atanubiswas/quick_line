@extends('layouts.admin_layout')
@section('title', "Page Setup")
@section('extra_css')
<style type="text/css">
    label em{
        color: #FF0000;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card elevation-3">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">Enter Page Margins</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="margin_top" class="form-label">Top Margin (mm)</label>
                                <div class="input-group">
                                    <input type="number" name="margin_top" id="margin_top" class="form-control" placeholder="Enter top margin" min="0" step="0.1" required>
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="margin_bottom" class="form-label">Bottom Margin (mm)</label>
                                <div class="input-group">
                                    <input type="number" name="margin_bottom" id="margin_bottom" class="form-control" placeholder="Enter bottom margin" min="0" step="0.1" required>
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="margin_left" class="form-label">Left Margin (mm)</label>
                                <div class="input-group">
                                    <input type="number" name="margin_left" id="margin_left" class="form-control" placeholder="Enter left margin" min="0" step="0.1" required>
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="margin_right" class="form-label">Right Margin (mm)</label>
                                <div class="input-group">
                                    <input type="number" name="margin_right" id="margin_right" class="form-control" placeholder="Enter right margin" min="0" step="0.1" required>
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Margins
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection