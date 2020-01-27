@php
/** @var \Tarik02\LaravelMixin\Contracts\Data\MixedClass $class */

echo '<?php';
@endphp


namespace {{ $class->getNamespace() }};

@if($class->getBaseClass() !== null)
use {{ $class->getBaseClass() }} as Base;
@endif

class {{ $class->getShortName() }}
@if($class->getBaseClass() !== null)
    extends Base
@endif
@unless(empty($class->getMixedInterfaces()))
    implements
@foreach($class->getMixedInterfaces() as $interface)
        \{{ $interface }}
@endforeach
@endunless
{
@unless(empty($class->getMixedTraits()))
    use
@foreach($class->getMixedTraits() as $trait)
        \{{ $trait }}{{ $loop->last ? '' : ',' }}
@endforeach
    {
@foreach($class->getTraitsResolutions() as $resolution)
@switch($resolution['type'])
@case('insteadof')
        \{{ $resolution['trait'] }}::{{ $resolution['method'] }} insteadof \{{ $resolution['replacedTrait'] }};
@break
@case('as')
        \{{ $resolution['trait'] }}::{{ $resolution['oldName'] }} as {{ $resolution['newName'] }};
@break
@endswitch
@endforeach
    }
@endunless

    public function __construct(...$args)
    {
@foreach($class->getCodeBeforeConstruct() as $code)
        {!! $code !!}
@endforeach

@if($class->getBaseClass() !== null)
        parent::__construct(...$args);
@endif

@foreach($class->getCodeAfterConstruct() as $code)
        {!! $code !!}
@endforeach
    }

@foreach($class->getClassCode() as $code)
    {!! $code !!}
@endforeach
}
