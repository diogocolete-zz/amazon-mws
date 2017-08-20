<?php
/**
 * Created by PhpStorm.
 * User: diogo
 * Date: 20/08/17
 * Time: 12:08
 */

namespace ZendHunter\AmazonMwsFeed;

/**
 * Class FeedProcessingStatus
 * @package ZendHunter\AmazonMwsFeed
 *
 * The FeedProcessingStatus enumeration describes the processing status of a submitted feed.
 */
class FeedProcessingStatus
{
    /**
     * The request is being processed, but is waiting for external information before it can complete.
     */
    const AWAITING_ASYNCHRONOUS_REPLY = '_AWAITING_ASYNCHRONOUS_REPLY_';
    /**
     * The request has been aborted due to a fatal error.
     */
    const CANCELLED = '_CANCELLED_';
    /**
     * The request has been processed. You can call the GetFeedSubmissionResult operation to receive a processing
     * report that describes which records in the feed were successful and which records generated errors.
     */
    const DONE = '_DONE_';
    /**
     * The request is being processed.
     */
    const IN_PROGRESS = '_IN_PROGRESS_';
    /**
     * The request is being processed, but the system has determined that there is a potential error with the
     * feed (for example, the request will remove all inventory from a seller's account.)
     *
     * An Amazon seller support associate will contact the seller to confirm whether the feed should be processed.
     */
    const IN_SAFETY_NET = '_IN_SAFETY_NET_';
    /**
     * The request has been received, but has not yet started processing.
     */
    const SUBMITTED = '_SUBMITTED_';
    /**
     * The request is pending.
     */
    const UNCONFIRMED = '_UNCONFIRMED_';
}