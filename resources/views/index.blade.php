@extends('layout.app')
@push('jsonld')
  <x-schema-jsonld :graph="$schemaGraph" />
@endpush