@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Enregistrer un document</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                            <label for="source" class="col-md-4 control-label">Source</label>

                            <div class="col-md-6">
                                <input id="source" type="text" class="form-control" name="source" value="{{ old('source') }}" required autofocus placeholder="saisir le nom de la source du document">

                                @if ($errors->has('source'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('source') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sourceName') ? ' has-error' : '' }}">
                            <label for="sourceName" class="col-md-4 control-label">SourceName</label>

                            <div class="col-md-6">
                                <input id="sourceName" type="text" class="form-control" name="sourceName" value="{{ old('sourceName') }}" required placeholder="saisir le SourceName du document">

                                @if ($errors->has('sourceName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sourceName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                            <label for="version" class="col-md-4 control-label">Version</label>

                            <div class="col-md-4">
                                <select class="form-control" name="version" id="" required>
                                    <option value="" disabled="">-- choisir une version --</option>
                                    <option value="electronique">Electronique</option>
                                    <option value="papier">Papier</option>
                                </select>

                                @if ($errors->has('version'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('version') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                            <label for="version" class="col-md-4 control-label">Fréquence</label>

                            <div class="col-md-4">
                                <select class="form-control" name="frequence" id="" required>
                                    <option value="" disabled="">-- choisir une fréquence --</option>
                                    <option value="quotidien">Quotidien</option>
                                    <option value="hebdomadaire">Hebdomadaire</option>
                                    <option value="mensuel">Mensuel</option>
                                </select>

                                @if ($errors->has('frequence'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('frequence') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                            <label for="version" class="col-md-4 control-label">Langue</label>

                            <div class="col-md-4">
                                <select class="form-control" name="lang" id="" required>
                                    <option value="" disabled="">-- choisir une langue --</option>
                                    <option value="arabe">Arabe</option>
                                    <option value="françcais">Français</option>
                                    <option value="anglais">Anglais</option>
                                </select>

                                @if ($errors->has('lang'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lang') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Enregistrer
                                </button>

                                <button type="reset" class="btn btn-default">
                                    Effacer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection