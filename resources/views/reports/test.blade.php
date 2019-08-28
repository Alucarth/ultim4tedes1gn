@extends('layouts.print')

@section('content')
<br>
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Responsable</td>
        <td colspan="3" class="text-xs uppercase"> Brian de Mena</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Dependencia</td>
        <td colspan="3" class="text-xs uppercase">Gorrioncillo Pecho Amarillo</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Proveedor</td>
        <td class="text-xs uppercase">Ende</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Telefono </td>
        <td class="text-xs uppercase">6666666</td>
    </tr>

</table>
<br>
<table class="table-info w-100">
    <thead class="bg-grey-darker">
        <tr class="font-medium text-white text-sm">
            <td class="px-15 py text-center text-xxs ">
                Nro.
            </td>
            <td class="px-15 py text-center  text-xxs">
                Unidad
            </td>
            <td class="px-15 py text-center text-xxs">
                Descripcion
            </td>
            <td class="px-15 py text-center text-xxs">
                Cantidad
            </td>
            <td class="px-15 py text-center text-xxs">
                Costo U
            </td>
            <td class="px-15 py text-center text-xxs">
                Costo Total
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $count=1;?>
        {{-- @foreach ($article_income->article_income_items as $item) --}}
            <tr class="text-sm">
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">1</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">XD</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">12</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">3</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">5</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">15</td>
            </tr>

        {{-- @endforeach --}}
            <tr class="text-sm">
                <td class="text-center text-xxs uppercase font-bold px-4 py-3 bg-grey-darker text-white" colspan="5">Total</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3" >15</td>
            </tr>
    </tbody>
</table>
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center">______________</td>
        <td class="text-center">______________</td>
    </tr>
    <tr>
        <td class="text-center text-xxs">Responsable de Almacen</td>
        <td class="text-center text-xxs">Area/Unidad Administrativa</td>
    </tr>
</table>

@endsection
