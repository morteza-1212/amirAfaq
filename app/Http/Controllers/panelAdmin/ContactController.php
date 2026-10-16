<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $contacts = Contact::query()
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Contact::count(),
        ];

        return view('panelAdmin.contact.index', compact('contacts', 'stats'));
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(Contact $contact): View
    {
        return view('panelAdmin.contact.show', compact('contact'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(Contact $contact): View
    {
        return view('panelAdmin.contact.edit', compact('contact'));
    }

    /* ============================================================
     |  Update (فقط یادداشت ادمین)
     ============================================================ */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'درخواست تماس با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'درخواست تماس با موفقیت حذف شد.');
    }
}
