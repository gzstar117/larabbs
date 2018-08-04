<?php

namespace App\Observers;

use App\Models\Topic;

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
}