<?php

namespace App\Services\Blogs;

use App\DTO\Blogs\BlogDto;
use App\Entity\Blog\Blog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\Models\Media;

class BlogsService
{

    public function paginateActive(int $count=20)
    {
        return Blog::orderBy('created_at', 'desc')
            ->where('active', 1)
            ->paginate($count);
    }

    public function paginateAll(int $count=20)
    {
        return Blog::orderBy('created_at', 'desc')
            ->paginate($count);
    }

    /**
     * @param mixed $slug
     * @return mixed
     */
    public function find($slug)
    {
        return Cache::tags(Blog::class)->rememberForever('blog_'.$slug, function () use ($slug) {
            return Blog::with('translations')
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();
        });
    }


    /**
     * @param BlogDto $dto
     * @return Blog
     * @throws \Throwable
     */
    public function create(BlogDto $dto): Blog
    {
        $blog = new Blog;

        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getContent() as $translation)
            $translations_array['content:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getTitle() as $translation)
            $translations_array['title:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getShortDescription() as $translation)
            $translations_array['short_description:'.$translation->getLocale()] = $translation->getValue();

        $blog->fill($translations_array);
        $blog->slug = $dto->getSlug();

        $blog->saveOrFail();

        if($dto->getCover()) {
            $this->uploadCover($dto->getCover(), $blog);
        }

        return $blog;
    }

    /**
     * @param Blog $blog
     * @param BlogDto $dto
     * @return bool
     * @throws \Throwable
     */
    public function update(Blog $blog, BlogDto $dto)
    {
        // проставляем переводы
        $translations_array = [];
        foreach ($dto->getContent() as $translation)
            $translations_array['content:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getTitle() as $translation)
            $translations_array['title:'.$translation->getLocale()] = $translation->getValue();
        foreach ($dto->getShortDescription() as $translation)
            $translations_array['short_description:'.$translation->getLocale()] = $translation->getValue();

        $blog->fill($translations_array);
        $blog->slug = $dto->getSlug();

        $result = $blog->saveOrFail();

        if($result && $dto->getCover()) {
            // удаляем текущую обложку, если есть
            if($blog->cover)
                $blog->cover->delete();
            // загружаем новую обложку
            $this->uploadCover($dto->getCover(), $blog);
        }

        return $result;
    }

    /**
     * @param UploadedFile $file
     * @param Blog $blog
     * @return Media
     * @throws \Exception
     */
    public function uploadCover(UploadedFile $file, Blog $blog): Media
    {
        // удаляем прошлую заставку
        $blog->clearMediaCollection('cover');
        // выставляем новую
        return $blog->addMedia($file)
            ->usingFileName(md5(random_bytes(6)) . '.' . $file->extension())
            ->toMediaCollection('cover');
    }

}
