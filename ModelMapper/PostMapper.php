<?php


namespace ModelMapper;

use LibraryDatabase\DatabaseAdapterInterface;


class PostMapper extends AbstractDataMapper implements PostMapperInterface
{
    protected $commentMapper;
    protected $entityTable = "posts";

    public function __construct(DatabaseAdapterInterface $adapter, CommentMapperInterface $commentMapper) {
        $this->commentMapper = $commentMapper;
        parent::__construct($adapter);
    }

    public function insert(PostInterface $post) {
        $post->id = $this->adapter->insert($this->entityTable,
            array("title"   => $post->title,
                "content" => $post->content));

        return $post->id;
    }

    public function delete($id) {
        if ($id instanceof PostInterface) {
            $id = $id->id;
        }

        $this->adapter->delete($this->entityTable, "id = $id");
        return $this->commentMapper->delete("post_id = $id");
    }

    protected function createEntity(array $row) {
        $comments = $this->commentMapper->findAll(
            array("post_id" => $row["id"]));

        return new Post($row["title"], $row["content"], $comments);
    }
}