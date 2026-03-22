import { Container, Row, Col, Card, Badge } from "react-bootstrap";

const CardGrid = ({ cards }) => {
    return (
        <Container fluid className="cardsGrid">
            <Row xs={2} sm={3} md={4} lg={6} xl={7} className="g-3">
                {cards.map((card) => (
                    <Col key={card.id}>
                        <div className="position-relative">
                            <Card className="shadow-sm border-0">
                                <Card.Img
                                    variant="top"
                                    src={card.image_url}
                                    alt={card.name}
                                    style={{
                                        objectFit: "cover",
                                        height: "100%",
                                    }}
                                    className="rounded"
                                />
                            </Card>

                            {/* Count badge */}
                            {card.quantity > 1 && (
                                <Badge
                                    bg="dark"
                                    className="position-absolute top-0 end-0 m-1 rounded"
                                >
                                    x{card.quantity}
                                </Badge>
                            )}
                        </div>
                    </Col>
                ))}
            </Row>
        </Container>
    );
};

export default CardGrid;
