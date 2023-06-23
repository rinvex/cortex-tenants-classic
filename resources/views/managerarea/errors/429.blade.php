@extends('cortex/tenants::managerarea.layouts.error')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
