import express from 'express';

const router = express.Router();

// GET endpoint
router.get('/protocolos', (req, res) => {
    res.send('Hello, world!');
});

export default router;
