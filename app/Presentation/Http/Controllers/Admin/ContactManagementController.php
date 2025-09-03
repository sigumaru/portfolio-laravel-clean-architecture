<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Repositories\ContactRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ContactManagementController
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
    ) {}

    public function index(Request $request): View
    {
        $page = (int) $request->get('page', 1);
        $perPage = 20;

        $contacts = $this->contactRepository->findWithPagination($page, $perPage);
        $unreadCount = $this->contactRepository->countUnread();

        return view('admin.contact.index', [
            'contacts' => $contacts,
            'unreadCount' => $unreadCount,
            'currentPage' => $page
        ]);
    }

    public function show(string $id): View|RedirectResponse
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact message not found');
        }

        // Mark as read when viewing
        if (!$contact->isRead()) {
            $contact->markAsRead();
            $this->contactRepository->save($contact);
        }

        return view('admin.contact.show', [
            'contact' => $contact
        ]);
    }

    public function markAsRead(string $id): RedirectResponse
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact message not found');
        }

        $contact->markAsRead();
        $this->contactRepository->save($contact);

        return redirect()->back()
            ->with('success', 'Message marked as read');
    }

    public function markAsUnread(string $id): RedirectResponse
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact message not found');
        }

        $contact->markAsUnread();
        $this->contactRepository->save($contact);

        return redirect()->back()
            ->with('success', 'Message marked as unread');
    }

    public function destroy(string $id): RedirectResponse
    {
        if (!$this->contactRepository->exists($id)) {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact message not found');
        }

        try {
            $this->contactRepository->delete($id);

            return redirect()->route('admin.contact.index')
                ->with('success', 'Contact message deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting contact message: ' . $e->getMessage());
        }
    }
}