<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Backend\Slider\SliderRequest;
use App\Http\Requests\Backend\Slider\UpdateSliderRequest;

class BackSliderController extends Controller
{
    public function index(){

        $sliders = Slider::get();
        return view('manager.slider.list_slider' ,compact('sliders'));
    }

    public function store(SliderRequest $request){

        $data = $request->validated();

         $data['is_active'] = $request->has('is_active');

         if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('sliders', $filename, 'public');
        $data['image'] = $filename;
        }


        Slider::create($data);
        return redirect()->route('slider.view')->with('success', 'Slider uğurla əlavə edildi.');



    }


    public function update(UpdateSliderRequest $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {

            if ($slider->image && Storage::disk('public')->exists('sliders/' . $slider->image)) {
                Storage::disk('public')->delete('sliders/' . $slider->image);
            }

            $file = $request->file('image');
            $filename = 'slider_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['image'] = $filename;
        }

        $slider->update($data);

        return redirect()
            ->route('slider.view')
            ->with('success', 'Slider uğurla yeniləndi.');
    }

   public function destroy($id)
{
    $slider = Slider::findOrFail($id);

    // Şəkil varsa və storage-də mövcuddursa sil
    if ($slider->image && Storage::disk('public')->exists('sliders/' . $slider->image)) {
        Storage::disk('public')->delete('sliders/' . $slider->image);
    }

    // Slider-i DB-dən sil
    $slider->delete();

    return redirect()
        ->route('slider.view')
        ->with('success', 'Slider uğurla silindi.');
}

}
