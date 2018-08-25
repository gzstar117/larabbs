<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //给Topic的内容做XSS防御, XSS的过滤配置在文件 config\purifier.php
        $topic->body = clean($topic->body, 'user_topic_body');

        //给Topic生成摘要
        $topic->excerpt = make_excerpt($topic->body);

    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            //不使用队列任务的实时翻译
//            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);

            // 推送任务到队列进行翻译
            /*
             * PS:
             * 由于推送任务TranslateSlug( ) 里面会序列化$topic Model的自增id, 因此这个推送任务不能放在 Topic的模型监控器中的saving()事件, 因此那时Topic还没有新建并且存入数据库, 因此还没有自增id。
             * 所以必需放在saved()事件中, 此事件发生在创建和编辑时、数据入库以后。在 saved() 方法中调用, 确保了我们在分发任务时, $topic->id 永远有值。
             */
            dispatch(new TranslateSlug($topic));
        }
    }
}