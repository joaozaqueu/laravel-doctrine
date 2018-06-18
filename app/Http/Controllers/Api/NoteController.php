<?php

namespace App\Http\Controllers\Api;

use App\Entities\Note;
use App\Entities\User;
use Doctrine\ORM\EntityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $qb = $this->em->createQueryBuilder();

        $qb->select('n.id, n.description, n.title, n.createdAt, n.updatedAt')
            ->from(Note::class, 'n')
            ->where($qb->expr()->eq('n.user', $user->getAuthIdentifier()));

        $notes = $qb->getQuery()->getResult();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $title = $request->input('title');
        $description = $request->input('description');

        /** @var Note $note */
        $note = new Note();

        $note
            ->setUser($user)
            ->setTitle($title)
            ->setDescription($description);

        $this->em->persist($note);
        $this->em->flush();

        return response()->json([]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function edit($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $qb = $this->em->createQueryBuilder();

        $qb->select('n.id, n.description, n.title, n.createdAt, n.updatedAt')
            ->from(Note::class, 'n')
            ->andWhere($qb->expr()->eq('n.id', $id))
            ->andWhere($qb->expr()->eq('n.user', $user->getAuthIdentifier()));

        $note = $qb->getQuery()->getOneOrNullResult();

        return view('note.edit', compact('note'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();

        $qb = $this->em->createQueryBuilder();

        $qb->select('n.id, n.description, n.title, n.createdAt, n.updatedAt')
            ->from(Note::class, 'n')
            ->andWhere($qb->expr()->eq('n.id', $id))
            ->andWhere($qb->expr()->eq('n.user', $user->getAuthIdentifier()));

        $note = $qb->getQuery()->getOneOrNullResult();

        $title = $request->input('title');
        $description = $request->input('description');

        $note
            ->setUser($user)
            ->setTitle($title)
            ->setDescription($description);

        $this->em->persist($note);
        $this->em->flush();

        return response()->json([]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function destroy(Request $request, $id)
    {
        /** @var User $user */
        $user = Auth::user();

        $qb = $this->em->createQueryBuilder();

        $qb->select('n.id, n.description, n.title, n.createdAt, n.updatedAt')
            ->from(Note::class, 'n')
            ->andWhere($qb->expr()->eq('n.id', $id))
            ->andWhere($qb->expr()->eq('n.user', $user->getAuthIdentifier()));

        $note = $qb->getQuery()->getOneOrNullResult();

        $this->em->remove($note);
        $this->em->flush();

        return response()->json([]);
    }
}
