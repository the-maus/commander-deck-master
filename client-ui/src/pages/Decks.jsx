import React, { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button, CardLink } from "react-bootstrap";
import api from "../services/api";
import Loading from "../components/Loading";
import { useNavigate } from "react-router";
import { useAuth } from "../context/AuthContext";

const Decks = () => {
    const [decks, setDecks] = useState([]);
    const [page, setPage] = useState(1);
    const [nextPage, setNextPage] = useState(true);
    const [prevPage, setPrevPage] = useState(false);
    const [loading, setLoading] = useState(true);
    const {logout} = useAuth();    

    const navigate = useNavigate();

    const loadDecks = async () => {
        setLoading(true);

        try {
            const response = await api.get("/decks", {
                params: { page: page },
            });
            console.log(response);
            setDecks(response.data.data.data);

            response.data.data.last_page == page
                ? setNextPage(false)
                : setNextPage(true);
            page > 1 ? setPrevPage(true) : setPrevPage(false);
        } catch (error) {
            if (error.response && error.response.status === 401) {
                console.log(error.response.data.message)
                logout();
                navigate('/login');
            }
        }

        setLoading(false);
    };

    useEffect(() => {
        console.log('loading decks');
        loadDecks();
        window.scrollTo(0, 0);
    }, [page]);

    return (
        <>
            <Container fluid>
                <Row>
                    {decks &&
                        decks.map((deck) => (
                            <Col md={4} className="mb-4" key={deck.id}>
                                <Card className="rounded" 
                                    style={{ cursor: "pointer" }}
                                    onClick={() =>
                                        navigate(`/edit-deck/${deck.id}`)
                                    }
                                >
                                    <img
                                        src={deck.art_crop}
                                        className="card-img-top"
                                        alt="Image 1"
                                    />
                                    <Card.Body>
                                        <Card.Title className="card-title text-primary">
                                            {deck.name}
                                        </Card.Title>
                                        <Card.Text>
                                            {deck.commander_name}
                                        </Card.Text>
                                    </Card.Body>
                                </Card>
                            </Col>
                        ))}
                </Row>
                {!loading && (
                    <Container>
                        <Row className="align-items-center">
                            <Col className="text-center">
                                {prevPage && (
                                    <Button
                                        variant="secondary"
                                        className="me-2"
                                        onClick={() => setPage(page - 1)}
                                    >
                                        Back
                                    </Button>
                                )}
                                {nextPage && (
                                    <Button
                                        variant="primary"
                                        onClick={() => setPage(page + 1)}
                                    >
                                        Next
                                    </Button>
                                )}
                            </Col>
                        </Row>
                    </Container>
                )}
            </Container>
            {loading && <Loading />}
        </>
    );
};

export default Decks;
